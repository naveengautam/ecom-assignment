<?php

namespace App\Services;

use App\Events\OrderPlaced;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function checkout($userId)
    {
        try {
            DB::beginTransaction();
            // 1. Validate product stock. Get cart items with products details and vendor details
            $cartItems = CartItem::with('product.vendor')
                ->whereHas('cart', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->get();

            foreach ($cartItems as $item) {
                if ($item->quantity > $item->product->stock) {
                    throw new \Exception('Product ' . $item->product->name . ' is out of stock');
                }
            }
            // 2. Create orders for each vendor with the products in the cart.
            // seperate order for each vendor
            $vendorOrders = [];
            foreach ($cartItems as $item) {
                $vendorId = $item->product->vendor_id;
                if (!isset($vendorOrders[$vendorId])) {
                    $vendorOrders[$vendorId] = [];
                }
                $vendorOrders[$vendorId][] = $item;
            }
           // print_r($vendorOrders); exit;
            foreach ($vendorOrders as $vendorId => $items) {
                // a. Create order
                $order = Order::create([
                    'user_id' => $userId,
                    'vendor_id' => $vendorId,
                    'status' => 'paid', // for now, will implement payment later
                    'total_price' => collect($items)->sum(function ($item) {
                        return $item->quantity * $item->product->price;
                    }),
                ]);
                // Dispatch order event with full order model for listeners
                event(new OrderPlaced($order));
                // Need to create payment record with paid (I captured it in orders table by mistake)
                 $payment = Payment::create([
                     'order_id' => $order->id,
                     'status' => 'paid',
                 ]);
                 //payment succeeded event here
                 event(new \App\Events\PaymentSucceeded($payment));

                // b. Create order items for each product in the order
                foreach ($items as $item) {
                    $order->orderItems()->create([
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->product->price,
                    ]);
                    // c. Reduce stock for each product
                    $item->product->decrement('stock', $item->quantity);
                }
            }

            // 3. Process payment (will show paid for now).
            // Payment processing logic

            // 4. Empty the Cart and CartItem tables for the user after successful checkout.
            CartItem::whereHas('cart', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->delete();

            Cart::where('user_id', $userId)->delete();
            DB::commit();
            session(['cart_count' => '']);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}