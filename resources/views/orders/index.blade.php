@extends('layout.base')
<!-- order lists with order details and vendor details -->
@section('content')
    <h2>Your Orders</h2>
    @if(count($orders) > 0)
        @foreach($orders as $order)
            <div class="bg-white p-4 rounded shadow mb-4">
                <h3 class="text-lg font-bold">Order #{{ $order?->id }} - {{ $order?->vendor?->name }}</h3>
                <p class="text-gray-600">Status: {{ $order->status }}</p>
                <ul class="mt-2">
                    @foreach($order->orderItems as $item)
                        <li class="flex justify-between items-center py-2 border-b">
                            <div>
                                {{ $item->product->name }} (x{{ $item->quantity }})
                            </div>
                            <div>
                                ₹{{ number_format($item->quantity * $item->product->price, 2) }}
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="text-right font-bold mt-2">
                    Order Total: ₹{{ number_format($order->total_price, 2) }}
                </div>
            </div>
        @endforeach
         <!-- add pagination links -->
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @else
        <p>You have no orders.</p>
    @endif
@endsection
