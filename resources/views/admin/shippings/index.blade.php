@extends('layouts.admin')

@section('title', 'Shipments')

@section('content')
<div class="max-w-7xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-6">All Shipments</h2>
    <table class="min-w-full bg-white rounded shadow">
        <thead>
            <tr>
                <th class="py-2 px-4">Order #</th>
                <th class="py-2 px-4">Address</th>
                <th class="py-2 px-4">City</th>
                <th class="py-2 px-4">Country</th>
                <th class="py-2 px-4">Status</th>
                <th class="py-2 px-4">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shippings as $shipping)
            <tr class="border-t">
                <td class="py-2 px-4">{{ $shipping->order_id }}</td>
                <td class="py-2 px-4">{{ $shipping->address }}</td>
                <td class="py-2 px-4">{{ $shipping->city }}</td>
                <td class="py-2 px-4">{{ $shipping->country }}</td>
                <td class="py-2 px-4">{{ ucfirst($shipping->status) }}</td>
                <td class="py-2 px-4">
                    <a href="{{ route('admin.shipments.show', $shipping) }}" class="text-blue-600 hover:underline">View</a>
                </td>
            @endforeach
        </tbody>
    </table>
</div>
@endsection