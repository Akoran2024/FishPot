<?php

use App\Http\Controllers\TideController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/tides', [TideController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::apiResource('clients', ClientController::class);
});

Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware('auth');

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');

require __DIR__.'/auth.php';



Route::get('/tides', [TideController::class, 'index']);
