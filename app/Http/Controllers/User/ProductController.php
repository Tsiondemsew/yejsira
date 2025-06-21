<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;

class ProductController extends Controller
{ 
 public function index()
{
    $products = Product::where('stock', '>', 0)->paginate(12);
    $categories = Category::withCount(['products' => function($query) {
        $query->where('stock', '>', 0);
    }])->get();
    return view('users.products.index', compact('products', 'categories'));
}

public function byCategory($id)
{
    $category = Category::findOrFail($id);
    $products = Product::where('category_id', $id)->latest()->paginate(12);
    $products = $products->filter(function($product) {
        return $product->stock > 0;
    });
    $products = new \Illuminate\Pagination\LengthAwarePaginator(
        $products,
        $products->count(),
        12,
        request()->get('page', 1)
    );
    $categories = Category::withCount('products')->get();
    return view('users.products.index', compact('products', 'categories', 'category'));
}
public function show($id)
{
    $product = Product::findOrFail($id);
    if ($product->stock <= 0) {
        return redirect()->route('products.index')->with('error', 'This product is out of stock.');
    }
    $relatedProducts = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->where('stock', '>', 0)
        ->take(4)
        ->get();
    $categories = Category::withCount(['products' => function($query) {
        $query->where('stock', '>', 0);
    }])->get();
    return view('users.products.show', compact('product', 'relatedProducts', 'categories'));
}

public function category($id)
{
    $products = Product::where('category_id', $id)
        ->where('stock', '>', 0)
        ->latest()
        ->paginate(12);
    $categories = Category::withCount(['products' => function($query) {
        $query->where('stock', '>', 0);
    }])->get();
    return view('users.products.index', compact('products', 'categories'));
}
}
