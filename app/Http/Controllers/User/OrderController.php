<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;

class OrderController extends Controller
{ 
    
public function placeOrder(Request $request)
{
    // Eager load product relationship
    $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();

    if ($cartItems->isEmpty()) {
        return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
    }

    $order = new Order();
    $order->user_id = auth()->id();
    $order->total_amount = $cartItems->sum(function ($item) {
        return $item->product->price * $item->quantity;
    });
    $order->save();

    foreach ($cartItems as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
            'price' => $item->product->price,
        ]);
        // Reduce stock
        $product = Product::find($item->product_id);
        if ($product) {
            $oldStock = $product->stock;
            $product->stock = max(0, $product->stock - $item->quantity);
            $product->save();
            \Log::info("Stock updated for product {$product->id}: {$oldStock} -> {$product->stock}");
        }
    }

    // Clear cart
    Cart::where('user_id', auth()->id())->delete();

    return redirect()->route('cart.index')->with('success', 'Order placed successfully!');
}

    public function cancelOrder($id)
    {
        $order = Order::find($id);

        if (!$order || $order->user_id !== auth()->id()) {
            return redirect()->route('users.orders.history')->with('error', 'Order not found.');
        }
        // Restore stock
        foreach ($order->items as $item) {
            $product = Product::find($item->product_id);
            $product->stock += $item->quantity;
            $product->save();
        }

        $order->delete();

        return redirect()->route('users.orders.history')->with('success', 'Order canceled successfully!');
    }

    // public function viewOrder($id)
    // {
    //     $order = Order::with('items.product')->find($id);

    //     if (!$order || $order->user_id !== auth()->id()) {
    //         return redirect()->route('users.orders.history')->with('error', 'Order not found.');
    //     }

    //     return view('users.orders.view', compact('order'));
    // }
    // public function trackOrder($id)
    // {
    //     $order = Order::find($id);

    //     if (!$order || $order->user_id !== auth()->id()) {
    //         return redirect()->route('users.orders.history')->with('error', 'Order not found.');
    //     }

    //     return view('orders.track', compact('order'));
    // }
public function history()
{
    $orders =  Order::with('items.product')
        ->where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->get();

    return view('users.orders.history', compact('orders'));
}
}
