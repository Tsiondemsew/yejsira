@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Admin Dashboard</h2>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
            <h3 class="text-lg font-semibold text-indigo-600">Total Products</h3>
            <p class="text-3xl font-bold mt-2">{{ $totalProducts ?? 0 }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
            <h3 class="text-lg font-semibold text-indigo-600">Categories</h3>
            <p class="text-3xl font-bold mt-2">{{ $totalCategories ?? 0 }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
            <h3 class="text-lg font-semibold text-indigo-600">Users</h3>
            <p class="text-3xl font-bold mt-2">{{ $totalUsers ?? 0 }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
            <h3 class="text-lg font-semibold text-indigo-600">Orders</h3>
            <p class="text-3xl font-bold mt-2">{{ $totalOrders ?? 0 }}</p>
        </div>
    </div>

    <!-- Example Chart (requires Chart.js) -->
    <div class="bg-white p-6 rounded-2xl shadow mb-10">
        <h3 class="text-lg font-semibold text-indigo-600 mb-4">Sales Report</h3>
        <canvas id="salesChart" height="100"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($salesLabels ?? ['Jan','Feb','Mar']) !!},
                datasets: [{
                    label: 'Sales',
                    data: {!! json_encode($salesData ?? [0, 0, 0]) !!},
                    backgroundColor: 'rgba(79, 70, 229, 0.7)'
                }]
            }
        });
    </script>
@endsection