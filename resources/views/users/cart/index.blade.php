<!-- resources/views/cart/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4">
    <h2 class="text-2xl font-bold text-green-800 mb-6">Your Cart</h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div id="cartItems" class="space-y-4">
        <!-- All cart items will be displayed here -->
    </div>

    <script>
    function displayCart() {
        const guestCart = JSON.parse(localStorage.getItem('guestCart')) || {};
        const cartContainer = document.getElementById('cartItems');
        let total = 0;
        let html = '';
        
        // Create a map to store merged items
        const mergedItems = new Map();
        
        // Add guest cart items to the map
        Object.entries(guestCart).forEach(([productId, item]) => {
            mergedItems.set(productId, {
                id: productId,
                name: item.name,
                price: item.price,
                quantity: item.quantity,
                image: item.image
            });
        });
        
        // Add database cart items to the map, merging quantities if product exists
        @auth
            @foreach($cartItems as $cartItem)
                const productId = '{{ $cartItem->product_id }}';
                if (mergedItems.has(productId)) {
                    const existingItem = mergedItems.get(productId);
                    existingItem.quantity += {{ $cartItem->quantity }};
                } else {
                    mergedItems.set(productId, {
                        id: productId,
                        name: '{{ $cartItem->product->name }}',
                        price: {{ $cartItem->product->price }},
                        quantity: {{ $cartItem->quantity }},
                        image: '{{ asset('storage/' . $cartItem->product->image) }}'
                    });
                }
            @endforeach
        @endauth
        
        // Display merged items
        mergedItems.forEach(item => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;
            html += `
                <div class="bg-white rounded-lg shadow p-4 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <img src="${item.image}" class="w-24 h-24 object-cover rounded" alt="${item.name}">
                        <div>
                            <h4 class="text-lg font-bold text-gray-800">${item.name}</h4>
                            <p class="text-green-600 font-semibold">${item.price} Birr × ${item.quantity}</p>
                        </div>
                    </div>
                    <button onclick="removeFromCart(${item.id})" class="text-red-600 hover:text-red-800">Remove</button>
                </div>
            `;
        });

        if (mergedItems.size > 0) {
            const guestCartData = encodeURIComponent(JSON.stringify(guestCart));
            html += `
                <div class="text-right text-xl font-bold text-green-700 mt-4">
                    Total: ${total} Birr
                </div>
                <div class="text-right mt-6">
                    @auth
                        <a href="{{ route('checkout') }}?guest_cart=${guestCartData}" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                            Proceed to Checkout
                        </a>
                    @else
                        <a href="{{ route('login', ['redirect' => route('checkout')]) }}" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                            Login to Checkout
                        </a>
                    @endauth
                </div>
            `;
        } else {
            html = '<p class="text-gray-600">Your cart is empty.</p>';
        }

        cartContainer.innerHTML = html;
    }

    function removeFromCart(productId) {
        let guestCart = JSON.parse(localStorage.getItem('guestCart')) || {};
        delete guestCart[productId];
        localStorage.setItem('guestCart', JSON.stringify(guestCart));
        
        @auth
            // If user is logged in, also remove from database cart
            fetch(`{{ route('cart.remove', '') }}/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(() => {
                displayCart();
            });
        @else
            displayCart();
        @endauth
    }

    // Display cart when page loads
    displayCart();
    </script>
</div>
@endsection