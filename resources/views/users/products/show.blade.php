@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <!-- Product Image -->
        <div>
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-[400px] object-cover rounded-xl shadow">
        </div>

        <!-- Product Info -->
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $product->name }}</h1>
            @if($product->category)
                <div class="mb-2 text-sm text-gray-500">
                    Category: <span class="font-medium">{{ $product->category->name }}</span>
                </div>
            @endif
            <div class="mb-2 text-gray-500">Stock: {{ $product->stock }}</div>
            <p class="text-gray-600 mb-4">{{ $product->description }}</p> 
            <div class="text-indigo-600 text-2xl font-semibold mb-6">
                ${{ number_format($product->price, 2) }}
            </div>
            @if($product->stock > 0)
                @auth
                    @if(Auth::user()->is_admin)
                        <div class="mb-4">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-indigo-700 transition">
                                Edit Product
                            </a>
                        </div>
                    @else
                        <form action="{{ route('cart.store', $product->id) }}" method="POST" class="inline">
                            @csrf
                            <div class="flex items-center gap-4 space-x-3 mb-4">
                                <label for="quantity" class="font-medium">Quantity:</label>
                                <input
                                    type="number"
                                    id="quantity"
                                    name="quantity"
                                    value="1"
                                    min="1"
                                    max="{{ $product->stock }}"
                                    class="w-20 border rounded px-2 py-1"
                                    required
                                >
                            </div>
                            <div class="flex gap-4">
                                <button type="submit" class="px-6 py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition">
                                    Add to Cart
                                </button>
                                <button type="button" onclick="window.location.href='{{ route('checkout', ['product_id' => $product->id, 'quantity' => 1]) }}'" class="px-6 py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition">
                                    Buy Now
                                </button>
                            </div>
                        </form>
                        <form id="buy-now-form" action="{{ route('checkout') }}" method="GET" class="hidden">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1" id="buy-now-quantity">
                        </form>
                    @endif
                @endauth
                @guest
                    <div class="flex gap-4">
                        <a href="{{ route('login', ['redirect' => url()->current()]) }}" 
                           class="inline-block bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 transition duration-200">
                            Login to Buy
                        </a>
                        <button onclick="addToGuestCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, '{{ asset('storage/' . $product->image) }}')" 
                                class="inline-block bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition duration-200">
                            Add to Cart
                        </button>
                    </div>

                    <script>
                    function addToGuestCart(productId, name, price, image) {
                        // Get existing cart from localStorage or initialize empty cart
                        let cart = JSON.parse(localStorage.getItem('guestCart')) || {};
                        
                        // Add or update product in cart
                        cart[productId] = {
                            id: productId,
                            name: name,
                            price: price,
                            quantity: 1,
                            image: image
                        };
                        
                        // Save updated cart back to localStorage
                        localStorage.setItem('guestCart', JSON.stringify(cart));
                        
                        // Show success message
                        alert('Product added to cart!');
                    }
                    </script>
                @endguest
            @else
                <span class="inline-block px-4 py-2 bg-red-500 text-white rounded">Out of Stock</span>
            @endif
        </div>
    </div>

    @if($relatedProducts->count())
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-4">Related Products</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)  
                    <a href="{{ route('product.show', $related->id) }}" class="block border rounded-lg overflow-hidden shadow hover:shadow-lg transition-shadow duration-300 bg-white">
                        <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h2 class="font-semibold text-lg text-gray-900">{{ $related->name }}</h2>
                            <p class="text-green-600 font-semibold mt-1">${{ number_format($related->price, 2) }}</p>
                        </div>
                    </a>
                @endforeach 
            </div>
        </div>
    @endif
</div>
@endsection
