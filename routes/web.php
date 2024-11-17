<?php

use App\Models\Product;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [CategoryController::class, 'fetchCategoriesForWelcome'])->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/cart', function () {
    return view('orders.session.cart');
})->name('cart')->middleware('auth');

Route::get('/search-results', [ProductController::class, 'search'])->name('search.results');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'create', 'store']);
    Route::resource('order_items', OrderItemController::class);

    Route::resource('customers', CustomerController::class);
    Route::post('/customers/save', [CustomerController::class, 'store'])->name('customers.save');
    Route::post('/customers/use', [CustomerController::class, 'use'])->name('customers.use');

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/data', [OrderController::class, 'data'])->name('orders.data');
    Route::get('orders/create/{id}', [OrderController::class, 'create'])->name('orders.create');
    Route::post('orders/store', [OrderController::class, 'store'])->name('orders.store');
    Route::get('orders/show/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::delete('orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/orders/data', [OrderController::class, 'data'])->name('orders.data');
    Route::post('/orders/add-to-cart/{id}', [OrderItemController::class, 'addToCart'])->name('orders.addItemToCart');
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/confirm', [OrderController::class, 'confirmOrder'])->name('checkout.confirm');

    Route::get('/cart', function () {
        return view('orders.session.cart');
    })->name('cart')->middleware('auth');
    
        // Cart-related routes
    Route::get('/cart', [OrderController::class, 'viewCart'])->name('cart');
    Route::post('/cart/add/{id}', [OrderItemController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update', [OrderItemController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove', [OrderItemController::class, 'removeFromCart'])->name('cart.remove');   
    
});

require __DIR__.'/auth.php';
