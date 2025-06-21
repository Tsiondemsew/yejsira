@extends('layouts.admin')

@section('title', 'Shipment Details')

@section('content')
<div class="max-w-xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-6">Shipment for Order #{{ $shipping->order_id }}</h2>
    <div class="bg-white rounded shadow p-6">
        <div><strong>Address:</strong> {{ $shipping->address }}</div>
        <div><strong>City:</strong> {{ $shipping->city }}</div>
        <div><strong>Country:</strong> {{ $shipping->country }}</div>
        <div><strong>Postal Code:</strong> {{ $shipping->postal_code }}</div> 
        <div><strong>Status:</strong> {{ ucfirst($shipping->status) }}</div>

        <td class="py-2 px-4">
                    <form action="{{ route('admin.shipments.update', $shipping) }}" method="POST" class="flex items-center space-x-2">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="redirect_to" value="{{ request('from') == 'order' ? 'order' : 'shipment' }}">
                        <select name="status" class="border rounded px-2 py-1">
                            <option value="pending"   @if($shipping->status == 'pending') selected @endif>Pending</option> 
                            <option value="delivered" @if($shipping->status == 'delivered') selected @endif>Delivered</option>
                            <option value="cancelled" @if($shipping->status == 'cancelled') selected @endif>Cancelled</option>
                        </select>
                    </br>
                        <button type="submit" class="px-2 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-xs">Update</button>
                    </form>
                </td>
    </div>
</div>
@endsection