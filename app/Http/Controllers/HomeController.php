<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class HomeController extends Controller
{
     public function index()
    {
        $products = Product::where('stock', '>', 0)->latest()->take(8)->get();
        return view('home', compact('products'));
    }
}
