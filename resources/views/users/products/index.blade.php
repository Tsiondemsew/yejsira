@extends('layouts.app')

@section('title', 'All Products')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Category Navigation -->
    <div class="mb-8 flex flex-wrap gap-2">
        <a href="{{ route('products') }}" 
           class="px-4 py-2 rounded-full {{ !isset($category) ? 'bg-green-600 text-white' : 'bg-gray-100 hover:bg-gray-200' }} transition">
            All Products
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('products.byCategory', $cat->id) }}"
               class="px-4 py-2 rounded-full {{ isset($category) && $category->id == $cat->id ? 'bg-green-600 text-white' : 'bg-gray-100 hover:bg-gray-200' }} transition">
                {{ $cat->name }}
                <span class="text-sm ml-1">({{ $cat->products_count }})</span>
            </a>
        @endforeach
    </div>

    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            {{ isset($category) ? $category->name : 'All Products' }}
        </h1>
    </div>

    @if($products->count())
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
        @foreach($products as $product)
        <a href="{{ route('product.show', $product->id) }}" class="block border rounded-lg overflow-hidden shadow hover:shadow-lg transition-shadow duration-300 bg-white">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
            <div class="p-4">
                <h2 class="font-semibold text-lg text-gray-900">{{ $product->name }}</h2>
                <p class="text-sm text-gray-600 mt-1 mb-3">{{ Str::limit($product->description, 30) }}</p>
                <p class="text-green-600 font-semibold mt-1">${{ number_format($product->price, 2) }}</p>
            </div>
        </a>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $products->links() }}
    </div>
    @else
    <p class="text-gray-700">No products found.</p>
    @endif
</div>
@endsection
