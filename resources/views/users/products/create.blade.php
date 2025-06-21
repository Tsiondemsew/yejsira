@extends('layout')

@section('content')
<div class="p-4">
    <h1 class="text-xl font-bold mb-4">Add New Product</h1>
    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <input type="text" name="name" placeholder="Product Name" class="w-full border p-2 rounded" required>
        <textarea name="description" placeholder="Description" class="w-full border p-2 rounded"></textarea>
        <input type="number" name="price" placeholder="Price" class="w-full border p-2 rounded" required>
        <input type="number" name="stock" placeholder="Stock Quantity" class="w-full border p-2 rounded" required>
        <input type="file" name="image" class="w-full border p-2 rounded" required>
        <button class="bg-green-600 text-white px-4 py-2 rounded">Add Product</button>
    </form>
</div>
@endsection
