<!-- resources/views/checkout/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6">Checkout</h2>

    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Order Summary -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-4">Order Summary</h3>
            @if(isset($directPurchase))
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                             class="w-20 h-20 object-cover rounded-lg">
                        <div>
                            <h4 class="font-medium text-gray-900">{{ $product->name }}</h4>
                            <p class="text-sm text-gray-500">Quantity: {{ $quantity }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-gray-900">{{ number_format($product->price * $quantity, 2) }} Birr</p>
                    </div>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($cartItems as $item)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-4">
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" 
                                     class="w-20 h-20 object-cover rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $item->product->name }}</h4>
                                    <p class="text-sm text-gray-500">Quantity: {{ $item->quantity }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-medium text-gray-900">{{ number_format($item->product->price * $item->quantity, 2) }} Birr</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Shipping Address -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-4">Shipping Address</h3>
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-gray-900">{{ Auth::user()->address }}</p>
                <p class="text-gray-900">{{ Auth::user()->city }}, {{ Auth::user()->country }}</p>
                <p class="text-gray-900">{{ Auth::user()->postal_code }}</p>
                <a href="{{ route('profile.edit') }}" class="text-sm text-green-600 hover:text-green-700 mt-2 inline-block">
                    Update Address
                </a>
            </div>
        </div>

        <!-- Total and Place Order -->
        <div class="border-t pt-6">
            <div class="flex justify-between items-center mb-6">
                <span class="text-lg font-semibold">Total</span>
                <span class="text-2xl font-bold text-green-600">{{ number_format($total, 2) }} Birr</span>
            </div>

            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                @if(isset($directPurchase))
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="{{ $quantity }}">
                @else
                    <input type="hidden" name="guest_cart" value="{{ request()->query('guest_cart') }}">
                @endif
                <button type="submit" class="w-full bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
                    Place Order
                </button>
            </form>
        </div>
    </div>
</div>
@endsection