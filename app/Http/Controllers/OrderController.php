<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use App\Models\Order;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    /*
    *   1. Validate product stock.
    *   2. Create order for each vendor with the products in the cart.
            a. Create order
            b. Create order items for each product in the order
            c. Reduce stock for each product
    *   3. Process payment (will show paid for now).
        4. Empty the Cart and CartItem tables for the user after successful checkout.
    */

    public function checkout()
        {
            $userId = auth()->id();
            try {
                $this->orderService->checkout($userId);
                return redirect()->route('home')->with('success', 'Checkout successful');
            } catch (\Exception $e) {
                return redirect()->route('cart.index')->with('error', 'Checkout failed: ' . $e->getMessage());
            }
        }
    
    public function index()
    {   
        $userId = auth()->id();
        $orders = Order::with('orderItems.product')->where('user_id', $userId)->paginate(10);
        return view('orders.index', compact('orders'));

    }

    public function allOrders()
    {
        //check if filter is set and modify the query accordingly
        $searchField = request()->query('search');
        $status = request()->query('status');
        // if search field is set, search by customers and vendors name
        $orders = Order::with('user', 'vendor', 'orderItems.product')
            ->when($searchField, function ($query) use ($searchField) {
                $query->whereHas('user', function ($query) use ($searchField) {
                    $query->where('name', 'like', '%' . $searchField . '%');
                })->orWhereHas('vendor', function ($query) use ($searchField) {
                    $query->where('name', 'like', '%' . $searchField . '%');
                });
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->paginate(10);
        return view('admin.orders.all', compact('orders'));
    }
    /*
        * Admin can view details of each order, including customer information, products ordered, and order status.
        * Route: /orders/show/{id}
        * Method: GET
        * Access: Admin only
    */
    public function show($id)
    {
        $order = Order::with('user', 'vendor', 'orderItems.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

}
