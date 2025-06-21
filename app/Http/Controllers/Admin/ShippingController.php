<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipping;
use App\Models\Order;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index()
{
    $shippings =Shipping::with('order')->latest()->get();
    return view('admin.shippings.index', compact('shippings'));
}
public function show($id)
{
    $shipping = \App\Models\Shipping::with('order')->findOrFail($id);
    return view('admin.shippings.show', compact('shipping'));
}
 
    // public function userupdate(Request $request, $orderId)
    // {
    //     $order = Order::findOrFail($orderId);
    //     $data = $request->validate([
    //         'address' => 'required|string',
    //         'city' => 'required|string',
    //         'country' => 'required|string',
    //         'postal_code' => 'nullable|string',
    //         'status' => 'required|string',
    //     ]);
    //     $shipping = $order->shipping ?? new Shipping(['order_id' => $order->id]);
    //     $shipping->fill($data);
    //     $shipping->order_id = $order->id;
    //     $shipping->save();
 
    // }

public function update(Request $request, $id)
{
    $shipping = Shipping::findOrFail($id);
    $request->validate([
        'status' => 'required|string|in:pending,delivered,cancelled',
    ]);
    $shipping->status = $request->status;
    $shipping->save();
    if ($request->redirect_to === 'order' && $shipping->order_id) {
        return redirect()->route('admin.orders.show', $shipping->order_id)
            ->with('success', 'Shipment status updated!');
    } else {
        return redirect()->route('admin.shipments.show', $shipping->id)
            ->with('success', 'Shipment status updated!');
    }
    
}



}