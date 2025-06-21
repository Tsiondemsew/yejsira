@extends('layouts.app')

@section('content')

<!-- Product Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-10 text-center">🌟 Featured Products</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach($products as $product)
            <a href="{{ route('product.show', $product->id) }}">
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-lg transition duration-300 group overflow-hidden">
        <div class="relative">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                 class="h-48 w-full object-cover group-hover:scale-105 transition-transform duration-300">
            @if($product->isNew())
                <span class="absolute top-2 left-2 bg-green-600 text-white text-xs px-2 py-1 rounded-full shadow">
                    New
                </span>
            @endif
        </div>
        <div class="p-4">
            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-green-700 transition">
                {{ $product->name }}
            </h3>
            <p class="text-sm text-gray-600 mt-1 mb-3">{{ Str::limit($product->description, 30) }}</p>
            <div class="flex justify-between items-center">
                <span class="text-green-600 font-bold text-lg">${{ number_format($product->price, 2) }}</span>
                 
            </div>
        </div>
    </div>
</a>
@endforeach
        </div>
    </div>
</section>

@endsection
