<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Orders') }}
        </h2>
    </x-slot>
    <!-- back button -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
        <a href="{{ route('orders.all') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Back to Orders</a> 
    </div>
    <!-- show single order details with customer details and vendor details -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold">Order #{{ $order->id }}</h3>
                    <p>Status: {{ $order->status }}</p>
                    <p>Customer: {{ $order->user->name }}</p>
                    <p>Vendor: {{ $order->vendor->name }}</p>
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
            </div>
        </div>
    </div>
</x-app-layout>