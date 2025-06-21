@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold text-green-800 mb-8">🧾 Your Order History</h2>

    @forelse($orders as $order)
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <div class="flex justify-between items-center mb-4">
                <div class="text-lg font-semibold text-gray-700">
                    🛒 Order #{{ $order->id }}
                </div>
                <div class="text-sm text-gray-500">
                    {{ $order->created_at->format('F j, Y h:i A') }}
                </div>
            </div>

            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-lg">
                        <img 
                            src="{{ asset('storage/' . $item->product->image) }}" 
                            alt="{{ $item->product->name }}" 
                            class="w-20 h-20 object-cover rounded-lg border"
                            onerror="this.src='https://via.placeholder.com/80';"
                        >
                        <div class="flex-1">
                            <h4 class="text-lg font-semibold text-gray-800">{{ $item->product->name }}</h4>
                            <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Price</p>
                            <p class="text-md font-semibold text-gray-800">
                                {{ number_format($item->price * $item->quantity, 2) }} Birr
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 text-right font-bold text-green-700 text-xl">
                Total: {{ number_format($order->items->sum(fn($item) => $item->price * $item->quantity), 2) }} Birr
            </div>
        </div>
    @empty
        <div class="text-center text-gray-600">
            <p class="text-lg">🕊️ You have no orders yet.</p>
            <a href="{{ route('products') }}" class="mt-4 inline-block bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                Browse Products
            </a>
        </div>
    @endforelse
</div>
@endsection
