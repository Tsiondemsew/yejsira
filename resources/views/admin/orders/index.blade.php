@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="max-w-7xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-6">All Orders</h2>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    <table class="min-w-full bg-white rounded shadow">
        <thead>
            <tr>
                <th class="py-2 px-4">Order #</th>
                <th class="py-2 px-4">User</th>
                <th class="py-2 px-4">Total</th>
                <th class="py-2 px-4">Status</th>
                <th class="py-2 px-4">Placed At</th>
                <th class="py-2 px-4">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr class="border-t">
                <td class="py-2 px-4">{{ $order->id }}</td>
                <td class="py-2 px-4">{{ $order->user->name ?? 'Guest' }}</td>
                <td class="py-2 px-4">{{ $order->total ?? '-' }}</td>
                <td class="py-2 px-4">{{ ucfirst($order->status) }}</td>
                <td class="py-2 px-4">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                <td class="py-2 px-4">
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:underline">View</a>
                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline" onsubmit="return confirm('Delete this order?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline ml-2">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection