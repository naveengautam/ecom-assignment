@extends('layout.base')

@section('content')
    <h2>Products</h2>
    <!-- show success message if product is added to cart -->
     <div id="message-container"></div>
     <!-- show flash message for success or error -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    <!-- add product where it shows 3 product card in a row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($products as $product)
            <div class="bg-white p-4 rounded shadow">
                <h3 class="text-lg font-bold">{{ $product->name }}</h3>
                <p class="text-gray-600">{{ $product->description }}</p>
                <p class="text-gray-800 font-bold">₹{{ $product->price }}</p>
                <!-- show qty input and Add to Cart button next to each other -->
                <div class="mt-2 flex items-center">
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mr-2">Quantity:</label>
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="number" name="quantity" value="1" min="1" class="border border-gray-300 rounded p-2">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded ml-2">Add to Cart</button>
                </div>
            </div>
        @endforeach
    </div>
    <script>
        // add event listener to all Add to Cart buttons
        @auth
        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.previousElementSibling.previousElementSibling.value;
                const quantity = this.previousElementSibling.value;
                // send ajax request to add product to cart
                fetch('/cart/add/' + productId, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                        //console.log(data);
                      // show success or error message based on response and add new div new item addition to cart                 
                    const messageContainer = document.getElementById('message-container');
                    if (data.success) {
                        //add new div to message container with success message and green background
                        const messageDiv = document.createElement('div');
                        messageDiv.className = 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative';
                        messageDiv.setAttribute('role', 'alert');
                        messageDiv.innerHTML = `
                            <strong class="font-bold">Success!</strong>
                            <span class="block sm:inline">${data.message}</span>
                        `;
                        messageContainer.appendChild(messageDiv);
                        // send total item count in cart in response and update cart item count in navbar
                        console.log(data.cart_item_count);
                        document.getElementById('cart-item-count').textContent = data.cart_item_count;
                    } else {
                        //add new div to message container with error message and red background
                        const messageDiv = document.createElement('div');
                        messageDiv.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative';
                        messageDiv.setAttribute('role', 'alert');
                        messageDiv.innerHTML = `
                            <span class="block sm:inline">${data.message}</span>
                        `;
                        messageContainer.appendChild(messageDiv);
                    }
                });
            });
        });
        @else
        // if user is not authenticated, redirect to login page when Add to Cart button is clicked
        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('click', function() {
                window.location.href = '/login';
            });
        });
        @endauth
    </script>
@endsection