<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\OrderController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    // Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create')->can('create', 'App\Models\Product');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store')->can('create', 'App\Models\Product');
    Route::get('/products/{product}', [ProductController::class, 'edit'])->name('products.edit')->can('update', 'product');
    Route::patch('/products/{product}', [ProductController::class, 'update'])->name('products.update')->can('update', 'product');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy')->can('delete', 'product');

    
    Route::get('/cart_items', [CartItemController::class, 'index'])->name('cart_items.index');
    Route::post('/cart_items/{product}', [CartItemController::class, 'store'])->name('cart_items.store');
    Route::delete('/cart_items/{cartItem}', [CartItemController::class, 'destroy'])->name('cart_items.destroy');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
});

require __DIR__.'/auth.php';
