<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\CartService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        // show cart items grouped by vendor
        $userId = auth()->id();
        $cartItems = $this->cartService->getCartItemsGroupedByVendor($userId);
        $cartTotal = $this->cartService->calculateTotal($userId);
        return view('carts.index', compact('cartItems', 'cartTotal'));
    }


    public function addToCart(Request $request, $product): JsonResponse
    {
        $userId = auth()->id();
        $productData = $request->only(['product_id', 'quantity']);
        $response = $this->cartService->addToCart($userId, $productData);
        if (!$response['success']) {
            return response()->json(
                [
                 'message' => $response['message'],
                 'error' => true
                ]);
        } else {
            return response()->json(['message' => 'Product added to cart successfully', 'success' => true, 'cart_item_count' => $this->cartService->calculateTotalItemCount($userId)]);
        }
    }

    public function remove(Request $request, $productId)
    {
        $userId = auth()->id();
        $this->cartService->removeFromCart($userId, $productId);
        //redirect to cart page with success message
        return redirect()->route('cart.index')->with('success', 'Product removed from cart successfully');
    }

    public function deleteCartAfterCheckout()
    {
        // delete cart after checkout
        $this->cartService->deleteCartAfterCheckout();
    }

}
