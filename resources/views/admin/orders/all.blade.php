<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Orders') }}
        </h2>
    </x-slot>
    <br />
    <!-- add filter by vendor and customer via text field and status via dropdown (pending, paid) -->
     <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 m-10">
        <form method="GET" action="{{ route('orders.all') }}" class="flex space-x-4">
            <input type="text" name="search" placeholder="Customer OR Vendor Name" value="{{ request('search') }}" class="border rounded px-3 py-2 w-full">
            <select name="status" class="border rounded px-3 py-2 w-full">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
            </select>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
        </form>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(count($orders) > 0)
                        @foreach($orders as $order)
                            <!-- show small details in the table rows form of order order ID, Customer name, total price and view button for each order -->
                            <div class="bg-gray-100 p-4 rounded mb-4">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h3 class="text-lg font-bold">Order #{{ $order->id }}</h3>
                                        <p>Status: {{ $order->status }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-800 font-bold">Total: ₹{{ number_format($order->total_price, 2) }}</p>
                                        <!-- add view details button -->
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded mt-2 inline-block">View Details</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <!-- add pagination links -->
                        <div class="mt-4">
                            {{ $orders->links() }}
                        </div>
                       
                    @else
                        <p>No orders found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>