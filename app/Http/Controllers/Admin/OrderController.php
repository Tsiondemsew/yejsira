<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
        public function index()
    {
        $orders = Order::with('user', 'items.product')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    // Show a single order
    public function show($id)
    {
        $order = Order::with('user', 'items.product', 'shipping')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
      public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $request->validate([
            'status' => 'required|string|in:pending,completed,cancelled',
        ]);
        $order->status = $request->status;
        $order->save();

        return redirect()->route('admin.orders.index', $order)->with('success', 'Order status updated!');
    }

    // Delete an order
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted!');
    }
}
