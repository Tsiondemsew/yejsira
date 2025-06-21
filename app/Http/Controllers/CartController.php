<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $quantity = $request->input('quantity', 1);

        if (auth()->check()) {
            // Existing logic for authenticated users
            CartItem::updateOrCreate(
                ['user_id' => auth()->id(), 'product_id' => $productId],
                ['quantity' => $quantity]
            );
        } else {
            // Guest cart logic using session
            $cart = session()->get('cart', []);
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image
            ];
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }
} 