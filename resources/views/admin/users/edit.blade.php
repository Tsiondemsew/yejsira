{{-- resources/views/admin/users/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="max-w-xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-6">Edit User</h2>
    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label>Name</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2" value="{{ $user->name }}" required>
            @error('name')<p class="text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" class="w-full border rounded px-3 py-2" value="{{ $user->email }}" required>
            @error('email')<p class="text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label>Role</label>
            <select name="is_admin" class="w-full border rounded px-3 py-2">
                <option value="0" @if(!$user->is_admin) selected @endif>User</option>
                <option value="1" @if($user->is_admin) selected @endif>Admin</option>
            </select>
            @error('is_admin')<p class="text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Update</button>
    </form>
</div>
@endsection