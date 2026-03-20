<?php
/*
This service package will handle all cart related operations, such as adding items to the cart, removing items from the cart, and calculating the total price of the items in the cart. It will also handle any necessary interactions with the database to store and retrieve cart information for users.
*/
namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CartService
{
    public function addToCart($userId, $productData)
    {
        try {
            $productId = $productData['product_id'];
            $quantity = $productData['quantity'];

            // Check if the product exists
            $product = Product::find($productId);
            if (!$product) {
                throw new \Exception('Product not found');
            }
            // Check if product is already in CartItem
            $cartItem = CartItem::whereHas('cart', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->where('product_id', $productId)->first();

            // Check if requested quantity exceeds available stock
            if ($quantity > $product->stock || ($cartItem && ($cartItem->quantity + $quantity) > $product->stock)) {
                return [
                    'message' => 'Item is out of stock',
                    'success' => false,
                ];
            }

            if ($cartItem) {
                // Update quantity if product already in cart
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                // Add new product to cartItem table
                CartItem::create([
                    'cart_id' => Cart::firstOrCreate(['user_id' => $userId])->id,
                    'product_id' => $productId,
                    'quantity' => $quantity
                ]);
            }
            //
        session(['cart_count' => $this->calculateTotalItemCount($userId)]);
           return [
                    'message' => 'Item added successfully.',
                    'success' => true,
                ];
        } catch (\Exception $e) {
            // Handle exceptions, such as product not found or database errors
            return [
                    'message' => 'Something wrong',
                    'success' => false,
                ];
        }
    }

    public function removeFromCart($userId, $productId)
    {
        // Remove product from cartItem table
        CartItem::whereHas('cart', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('id', $productId)->delete();
        //echo 'here'; exit;
        session(['cart_count' => $this->calculateTotalItemCount($userId)]);
       
    }

    public function calculateTotal($userId)
    {
        // Calculate total price of items in cart
        return CartItem::whereHas('cart', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with('product')->get()->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }

    public function calculateTotalItemCount($userId)
    {
        // Calculate total count of items in cart
        return CartItem::whereHas('cart', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->sum('quantity');
    }

    public function getCartItemsGroupedByVendor($userId)
    {
        // Get cart items grouped by vendor
        return CartItem::whereHas('cart', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with('product.vendor')->get()->groupBy(function ($item) {
            return $item->product->vendor->name;
        });
    }

    function deleteCartAfterCheckout($userId) {
        // Delete cart and CartItem after checkout
        $cart = Cart::where('user_id', $userId)->first();
        if ($cart) {
            CartItem::where('cart_id', $cart->id)->delete();
            $cart->delete();
        }
    }
}