<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TideController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// API routes
Route::get('/tides', [TideController::class, 'index']);
Route::get('/products-list', [ProductController::class, 'apiIndex']);

Route::middleware('auth')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/orders', [OrderController::class, 'store']);
});

Route::get('/dashboard', function () {
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return redirect()->route('admin.users.index');
    })->name('admin.dashboard');

    // Admin User CRUD routes
    Route::resource('admin/users', AdminUserController::class)->names('admin.users');


    // Admin Product CRUD routes
    Route::resource('admin/products', ProductController::class)->names('admin.products');
    
    // Admin Order CRUD routes
    Route::resource('admin/orders', OrderController::class)->names('admin.orders');
    
    Route::get('/orders-list', [OrderController::class, 'index']);
    Route::apiResource('products', ProductController::class)->except(['index', 'store', 'update', 'destroy']);
    Route::apiResource('clients', ClientController::class);
    
    // Order Status Updates
    Route::patch('admin/orders/{order}/accept', [OrderController::class, 'accept'])->name('admin.orders.accept');
    Route::get('admin/orders/{order}/ship/form', [OrderController::class, 'showShipForm'])->name('admin.orders.ship.form'); // New route for shipping form
    Route::patch('admin/orders/{order}/ship', [OrderController::class, 'ship'])->name('admin.orders.ship');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');