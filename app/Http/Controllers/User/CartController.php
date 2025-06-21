<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
   
public function store(Request $request, $id)
{
     $quantity = $request->input('quantity',1);

    $product = Product::findOrFail($id);
    if ($product->stock < $quantity) {
        return redirect()->back()->with('error', 'Not enough stock available.');
    }

    // Check if the user is authenticated
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'You need to be logged in to add items to the cart.');
    }

    // Add product to cart
   
    $user = Auth::user();
    $cartItem = Cart::where('user_id', $user->id)->where('product_id', $id)->first();

    if ($cartItem) {
        $newQuantity = $cartItem->quantity + $quantity;
        $cartItem->quantity = min($newQuantity, $product->stock);
        $cartItem->save();
    } else {
        Cart::create([
            'user_id' => $user->id,
            'product_id' => $id,
            'quantity' => min($quantity, $product->stock),
        ]);
    }

    return redirect()->route('cart.index')->with('success', 'Product added to cart!');
}


public function index()
{
    $user = Auth::user();
    $cartItems = Cart::with('product')->where('user_id', $user->id)->get();
    return view('users.cart.index', compact('cartItems'));
}

public function remove($id)
{
    $user = Auth::user();
    Cart::where('user_id', $user->id)->where('product_id', $id)->delete();
    return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
}
}
