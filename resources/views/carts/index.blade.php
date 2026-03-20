@extends('layout.base')
<!-- Show cart items grouped by vendor and show total price for each vendor and total price for entire cart -->
@section('content')
    <h2>Your Cart</h2>

    @if(count($cartItems) > 0)
    <!-- add checkout button -->
    <div class="text-right mt-4">
        <a href="/checkout" class="bg-green-500 text-white px-4 py-2 rounded">Proceed to Checkout</a>
    </div>
    <br />
        @foreach($cartItems as $vendor => $items)
            <div class="bg-white p-4 rounded shadow mb-4">
                <h3 class="text-lg font-bold">{{ $vendor }}</h3>
                <ul class="mt-2">
                    @foreach($items as $item)
                        <li class="flex justify-between items-center py-2 border-b">
                            <div>
                                {{ $item->product->name }} (x{{ $item->quantity }})
                            </div>
                            <div>
                                ₹{{ number_format($item->quantity * $item->product->price, 2) }}
                            </div>
                            <!-- add remove from cart button next to each item -->
                            <form method="POST" action="/cart/remove/{{ $item->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Remove</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
                <div class="text-right font-bold mt-2">
                    Vendor Total: ₹{{ number_format($items->sum(function($item) { return $item->quantity * $item->product->price; }), 2) }}
                </div>
            </div>
        @endforeach
        <div class="text-right font-bold text-xl">
            Cart Total: ₹{{ number_format($cartTotal, 2) }}
        </div>
        <!-- add checkout button -->
        <div class="text-right mt-4">
            <a href="/checkout" class="bg-green-500 text-white px-4 py-2 rounded">Proceed to Checkout</a>
        </div>
    @else
        <p>Your cart is empty.</p>
    @endif
@endsection