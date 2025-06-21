@extends('layouts.admin')
@section('title', 'Admin - Products')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Manage Products</h1>
        <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow">Add New Product</a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($products->count())
    <table class="min-w-full bg-white border rounded shadow">
        <thead class="bg-gray-100 text-gray-600 uppercase text-sm">
            <tr>
                <th class="py-3 px-6 border-b">ID</th>
                <th class="py-3 px-6 border-b">Name</th>
                <th class="py-3 px-6 border-b">Price</th>
                <th class="py-3 px-6 border-b">Stock</th>
                <th class="py-3 px-6 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr class="border-b hover:bg-gray-50">
                <td class="py-3 px-6">{{ $product->id }}</td>
                <td class="py-3 px-6">{{ $product->name }}</td>
                <td class="py-3 px-6 text-green-600 font-semibold">${{ number_format($product->price, 2) }}</td>
                <td class="py-3 px-6">{{ $product->stock }}</td>
                <td class="py-3 px-6 space-x-2">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-indigo-600 hover:text-indigo-800">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
    @else
    <p class="text-gray-700">No products found.</p>
    @endif
</div>
@endsection
