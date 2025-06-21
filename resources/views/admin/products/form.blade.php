{{-- resources/views/admin/products/form.blade.php --}}
@php
    $isEdit = isset($product);
@endphp

@section('title', $isEdit ? 'Edit Product' : 'Add New Product')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10 bg-white rounded-lg shadow">
    <h1 class="text-3xl font-bold mb-8">{{ $isEdit ? 'Edit Product' : 'Add New Product' }}</h1>

    <form action="{{ $isEdit ? route('admin.products.update', $product->id) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div>
            <label for="name" class="block font-semibold mb-2">Product Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name ?? '') }}" 
                   class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            @error('name')<p class="text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="price" class="block font-semibold mb-2">Price ($)</label>
            <input type="number" name="price" id="price" step="0.01" min="0" value="{{ old('price', $product->price ?? '') }}"
                   class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            @error('price')<p class="text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="stock" class="block font-semibold mb-2">Stock Quantity</label>
            <input type="number" name="stock" id="stock" min="0" value="{{ old('stock', $product->stock ?? 0) }}"
                   class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            @error('stock')<p class="text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="category_id" class="block font-semibold mb-2">Category</label>
            <select name="category_id" id="category_id" class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                <option value="">Select Category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')<p class="text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="description" class="block font-semibold mb-2">Description</label>
            <textarea name="description" id="description" rows="5"
                      class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>{{ old('description', $product->description ?? '') }}</textarea>
            @error('description')<p class="text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="image" class="block font-semibold mb-2">Product Image {{ $isEdit ? '(Leave blank to keep current)' : '' }}</label>
            <input type="file" name="image" id="image" class="w-full" {{ $isEdit ? '' : 'required' }} accept="image/*" onchange="previewImage(event)">
            @error('image')<p class="text-red-600 mt-1">{{ $message }}</p>@enderror

            <div id="image-preview" class="mt-4">
                @if($isEdit && $product->image)
                    <img src="{{ asset('storage/products/' . $product->image) }}" alt="Current image" class="w-48 rounded shadow">
                @endif
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" 
                    class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition duration-300">
                {{ $isEdit ? 'Update Product' : 'Add Product' }}
            </button>
        </div>
    </form>
</div>

<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'w-48 rounded shadow';
            preview.appendChild(img);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection