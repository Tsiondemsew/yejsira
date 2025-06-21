<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class AdminController extends Controller
{
     
public function index()
{
    $totalProducts = \App\Models\Product::count();
    $totalCategories = \App\Models\Category::count();
    $totalUsers = \App\Models\User::count();
    $totalOrders = \App\Models\Order::count();

     $orders = Order::where('status', 'completed')
        ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
        ->get()
        ->groupBy(function($order) {
            return Carbon::parse($order->created_at)->format('Y-m');
        });

    $months = [];
    $sales = [];
    $period = \Carbon\CarbonPeriod::create(now()->subMonths(11)->startOfMonth(), '1 month', now()->startOfMonth());

    foreach ($period as $date) {
        $label = $date->format('Y-m');
        $months[] = $label;
        $sales[] = isset($orders[$label]) ? $orders[$label]->sum('total'): 0;
    }
   // dd($months, $sales, $orders);

 

return view('admin.dashboard', [
    'totalProducts' => Product::count(),
    'totalCategories' => Category::count(),
    'totalUsers' => User::count(),
    'totalOrders' => Order::count(),
    'salesLabels' => $months,
    'salesData' => $sales,
]);
    } 

    public function dashboard()
    {
        if (!session('is_admin')) {
            return redirect()->route('login');
        }

        return view('admin.dashboard');
    }
}
