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
Route::get('/products-list', [ProductController::class, 'index']);

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
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/pedidos', function () {
        return view('admin.dashboard');
    })->name('admin.pedidos');

    Route::get('/admin/productos', function () {
        return view('admin.dashboard');
    })->name('admin.productos');

    Route::get('/admin/usuarios', function () {
        return view('admin.dashboard');
    })->name('admin.usuarios');
    
    Route::get('/admin/users-list', [AdminUserController::class, 'index']);
    Route::patch('/admin/users/{user}/role', [AdminUserController::class, 'updateRole']);
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy']);
    
    Route::get('/orders-list', [OrderController::class, 'index']);
    Route::apiResource('products', ProductController::class)->except(['index']);
    Route::apiResource('clients', ClientController::class);
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');