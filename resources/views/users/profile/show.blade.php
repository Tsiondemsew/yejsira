@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Profile Information</h2>
            <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                Edit Profile
            </a>
        </div>

        <div class="space-y-4">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Name</h3>
                <p class="mt-1 text-lg text-gray-900">{{ $user->name }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500">Email</h3>
                <p class="mt-1 text-lg text-gray-900">{{ $user->email }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500">Address</h3>
                <p class="mt-1 text-lg text-gray-900">{{ $user->address ?? 'Not set' }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500">City</h3>
                <p class="mt-1 text-lg text-gray-900">{{ $user->city ?? 'Not set' }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500">Country</h3>
                <p class="mt-1 text-lg text-gray-900">{{ $user->country ?? 'Not set' }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500">Postal Code</h3>
                <p class="mt-1 text-lg text-gray-900">{{ $user->postal_code ?? 'Not set' }}</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mt-4 p-4 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif
    </div>
</div>
@endsection 