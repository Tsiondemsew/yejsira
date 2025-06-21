<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipping;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Check if this is a direct purchase
        if ($request->has('product_id') && $request->has('quantity')) {
            $product = Product::findOrFail($request->product_id);
            $quantity = min($request->quantity, $product->stock);
            $total = $product->price * $quantity;
            
            return view('users.checkout.index', [
                'directPurchase' => true,
                'product' => $product,
                'quantity' => $quantity,
                'total' => $total
            ]);
        }
        
        // Get database cart items
        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();
        
        // Get guest cart items from URL
        $guestCartItems = collect();
        if ($request->has('guest_cart')) {
            $guestCart = json_decode(urldecode($request->guest_cart), true) ?? [];
            foreach ($guestCart as $productId => $item) {
                $product = Product::find($productId);
                if ($product) {
                    $guestCartItems->push((object)[
                        'product' => $product,
                        'quantity' => $item['quantity']
                    ]);
                }
            }
        }
        
        // Merge both cart items
        $allCartItems = $cartItems->concat($guestCartItems);
        
        // Merge similar products
        $mergedItems = new Collection();
        $allCartItems->each(function ($item) use ($mergedItems) {
            $existingItem = $mergedItems->first(function ($mergedItem) use ($item) {
                return $mergedItem->product->id === $item->product->id;
            });
            
            if ($existingItem) {
                $existingItem->quantity += $item->quantity;
            } else {
                $mergedItems->push((object)[
                    'product' => $item->product,
                    'quantity' => $item->quantity
                ]);
            }
        });
        
        // Calculate total
        $total = $mergedItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });
        
        return view('users.checkout.index', [
            'cartItems' => $mergedItems,
            'total' => $total
        ]);
    }

    public function process(Request $request)
    {
        $user = Auth::user();
        
        // Check if user has address information
        if (!$user->address || !$user->city || !$user->country) {
            return redirect()->route('profile.edit')
                ->with('error', 'Please update your shipping address in your profile before placing an order.');
        }
        
        // Handle direct purchase
        if ($request->has('product_id') && $request->has('quantity')) {
            $product = Product::findOrFail($request->product_id);
            $quantity = min($request->quantity, $product->stock);
            
            if ($quantity <= 0) {
                return redirect()->back()->with('error', 'Sorry, this product is out of stock.');
            }
            
            $total = $product->price * $quantity;
            
            DB::transaction(function () use ($user, $product, $quantity, $total) {
                // Create order
                $order = Order::create([
                    'user_id' => $user->id,
                    'total' => $total,
                ]);

                // Create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]);

                // Create shipping
                Shipping::create([
                    'order_id' => $order->id,
                    'address' => $user->address,
                    'city' => $user->city,
                    'country' => $user->country,
                    'postal_code' => $user->postal_code,
                    'status' => 'pending',
                ]);

                // Update product stock
                $product->decrement('stock', $quantity);
            });

            return redirect()->route('orders.history')->with('success', 'Order placed successfully!');
        }

        // Get database cart items
        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();
        
        // Get guest cart items from request
        $guestCartItems = collect();
        if ($request->has('guest_cart')) {
            $guestCart = json_decode(urldecode($request->guest_cart), true) ?? [];
            foreach ($guestCart as $productId => $item) {
                $product = Product::find($productId);
                if ($product) {
                    $guestCartItems->push((object)[
                        'product' => $product,
                        'quantity' => $item['quantity']
                    ]);
                }
            }
        }
        
        // Merge both cart items
        $allCartItems = $cartItems->concat($guestCartItems);
        
        // Merge similar products
        $mergedItems = new Collection();
        $allCartItems->each(function ($item) use ($mergedItems) {
            $existingItem = $mergedItems->first(function ($mergedItem) use ($item) {
                return $mergedItem->product->id === $item->product->id;
            });
            
            if ($existingItem) {
                $existingItem->quantity += $item->quantity;
            } else {
                $mergedItems->push((object)[
                    'product' => $item->product,
                    'quantity' => $item->quantity
                ]);
            }
        });
        
        if ($mergedItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Check stock availability
        foreach ($mergedItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->back()->with('error', "Sorry, we only have {$item->product->stock} units of {$item->product->name} in stock.");
            }
        }

        $total = $mergedItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        DB::transaction(function () use ($user, $mergedItems, $total) {
            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $total,
            ]);

            // Create order items and update stock
            foreach ($mergedItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product->id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                // Update product stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Create shipping
            Shipping::create([
                'order_id' => $order->id,
                'address' => $user->address,
                'city' => $user->city,
                'country' => $user->country,
                'postal_code' => $user->postal_code,
                'status' => 'pending',
            ]);
        });

        // Clear both carts
        Cart::where('user_id', $user->id)->delete();
        
        return redirect()->route('orders.history')->with('success', 'Order placed successfully!');
    }
}
