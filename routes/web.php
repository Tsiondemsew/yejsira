<?php

use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\OrderController; 
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\Admin\ShippingController; 


use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CategoryController; 
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;



require __DIR__.'/auth.php';

 

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/category/{id}', [ProductController::class, 'byCategory'])->name('products.byCategory'); 
//Route::resource('users', UserController::class)->only(['index', 'edit', 'update', 'destroy']);
 

Route::middleware(['auth'])->prefix('users')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::post('/cart/{id}', [CartController::class, 'store'])->name('cart.store');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/placeOrder', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/orders', [OrderController::class, 'history'])->name('orders.history');
    Route::post('/placeOrder', [OrderController::class, 'placeOrder'])->name('order.placeOrder');

}); 


Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () { 
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('users', UserController::class)->only(['index', 'edit', 'update', 'destroy']);
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update', 'destroy']); 
    Route::get('shipments', [ShippingController::class, 'index'])->name('shipments.index'); 
    Route::get('shipments/{shipment}', [ShippingController::class, 'show'])->name('shipments.show');
    Route::put('shipments/{shipment}', [ShippingController::class, 'update'])->name('shipments.update'); 

    Route::get('/profile', [AdminProfileController::class, 'show'])->name('profile');
    Route::put('/profile/update', [AdminProfileController::class, 'update'])->name('profile.update');
});
