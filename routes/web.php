<?php

use App\Http\Controllers\TideController;
use Illuminate\Support\Facades\Route;

Route::get('/tides', [TideController::class, 'index']);

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');