<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TideController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// API routes
Route::get('/tides', [TideController::class, 'index']);
Route::get('/products-list', [ProductController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::apiResource('clients', ClientController::class);
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    Route::apiResource('products', ProductController::class)->except(['index']);
    Route::apiResource('clients', ClientController::class);
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');