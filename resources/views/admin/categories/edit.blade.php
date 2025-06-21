@extends('layouts.admin')
@section('title', 'Edit Category')
@section('content')
<div class="max-w-xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-6">Edit Category</h2>
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label>Name</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2" value="{{ $category->name }}" required>
        </div>
        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Update</button>
    </form>
</div>
@endsection