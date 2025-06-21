<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel') - Yejsira</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100 font-sans text-gray-800 antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar -->  
<aside class=" w-64 bg-white shadow-lg ">
    <div class="p-6 text-2xl font-bold text-green-700 border-b ">Admin Panel</div>
    <nav class="flex-1 px-4 py-6 space-y-2 ">
        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded hover:bg-green-100 {{ request()->routeIs('admin.dashboard') ? 'bg-green-50 font-semibold' : '' }}">Dashboard</a>
        <a href="{{ route('admin.orders.index') }}" class="block px-4 py-2 rounded hover:bg-green-100 {{ request()->routeIs('admin.orders.*') ? 'bg-green-50 font-semibold' : '' }}">Orders</a>
        <a href="{{ route('admin.shipments.index') }}" class="block px-4 py-2 rounded hover:bg-green-100 {{ request()->routeIs('admin.shipments.*') ? 'bg-green-50 font-semibold' : '' }}">Shipments</a>
        <a href="{{ route('admin.products.index') }}" class="block px-4 py-2 rounded hover:bg-green-100 {{ request()->routeIs('admin.products.*') ? 'bg-green-50 font-semibold' : '' }}">Products</a>
        <a href="{{ route('admin.categories.index') }}" class="block px-4 py-2 rounded hover:bg-green-100 {{ request()->routeIs('admin.categories.*') ? 'bg-green-50 font-semibold' : '' }}">Categories</a>
        <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 rounded hover:bg-green-100 {{ request()->routeIs('admin.users.*') ? 'bg-green-50 font-semibold' : '' }}">Users</a>
        <a href="{{ route('admin.profile') }}" class="block px-4 py-2 rounded hover:bg-green-100 {{ request()->routeIs('admin.profile') ? 'bg-green-50 font-semibold' : '' }}">Profile</a>
        <a href="{{ route('home') }}" class="block px-4 py-2 rounded hover:bg-gray-100 text-blue-600">← Back to Site</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left px-4 py-2 rounded hover:bg-red-100 text-red-600">Logout</button>
        </form>
    </nav>
</aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            @yield('content')
        </main>
    </div>
</body>
</html>