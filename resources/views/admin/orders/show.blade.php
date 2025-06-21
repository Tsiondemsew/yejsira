@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="max-w-3xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-6">Order #{{ $order->id }}</h2>
    <div class="mb-4">
        <strong>User:</strong> {{ $order->user->name ?? 'Guest' }}<br>
        <strong>Email:</strong> {{ $order->user->email ?? '-' }}<br>
        <strong>Status:</strong> {{ ucfirst($order->status) }}<br>
        <strong>Placed At:</strong> {{ $order->created_at->format('Y-m-d H:i') }}<br>
        <strong>Total:</strong> {{ $order->total ?? '-' }}
        @if($order->shipping)
    </br>
        <a href="{{ route('admin.shipments.show',  [ $order->shipping->id , 'from' => 'order']) }}"
           class="inline-block mt-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            Check Shipment 
        </a>
    @else
        <span class="inline-block mt-2 px-4 py-2 bg-gray-300 text-gray-700 rounded">No shipment info</span>
    @endif
    </div>

    <h3 class="font-semibold mb-2">Order Items</h3>
    <table class="min-w-full bg-white rounded shadow mb-6">
        <thead>
            <tr>
                <th class="py-2 px-4">Product</th>
                <th class="py-2 px-4">Quantity</th>
                <th class="py-2 px-4">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr class="border-t">
                <td class="py-2 px-4">{{ $item->product->name ?? '-' }}</td>
                <td class="py-2 px-4">{{ $item->quantity }}</td>
                <td class="py-2 px-4">{{ $item->price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label for="status" class="block font-semibold mb-2">Update Status</label>
            <select name="status" id="status" class="w-full border rounded px-3 py-2"> 
                <option value="Pending" @if($order->status == 'Pending') selected @endif>Pending</option> 
                <option value="completed" @if($order->status == 'completed') selected @endif>Completed</option>
                <option value="cancelled" @if($order->status == 'cancelled') selected @endif>Cancelled</option>
            </select> 
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">Update Status</button>
    </form>
</div>
@endsection