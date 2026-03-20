<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- add tailwind css -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">   
    <title>E-commerce Store</title>
</head>
<body>
    <nav class="bg-gray-800 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-white text-lg font-bold">E-commerce Store</a>
            <ul>
               @auth
                    <li class="inline-block ml-4"><a href="/orders" class="text-gray-300 hover:text-white">Orders</a></li>
                    <li class="inline-block ml-4"><a href="/cart" class="text-gray-300 hover:text-white">Cart</a></li>
                    <li class="inline-block ml-4">
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit" class="text-gray-300 hover:text-white">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="inline-block ml-4"><a href="/login" class="text-gray-300 hover:text-white">Login</a></li>
                    <li class="inline-block ml-4"><a href="/register" class="text-gray-300 hover:text-white">Register</a></li>
                @endauth
                    <li class="inline-block ml-4"><a href="/cart" class="text-gray-300 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M16 11V3a1 1 0 00-1-1H4a1 1 0 00-1 1v8a1 1 0 001 1h11a1 1 0 001-1zM5 4h10v6H5V4zm2 9a2 2 0 100 4 2 2 0 000-4zm7-2a2 2 0 100 4 2 2 0 000-4z" />
                        </svg>
                        <span class="ml-1" id="cart-item-count">{{ session('cart_count', '') }}</span>
                    </a></li>

            </ul>
        </div>
    </nav>
    <div class="container mx-auto p-4">
        @yield('content')
    </div>
    <footer class="bg-gray-800 text-white p-4 mt-8">
        <div class="container mx-auto text-center">
            &copy; {{ date('Y') }} E-commerce Store. All rights reserved.
        </div>
    </footer>
    @stack('scripts')
</body>
</html>