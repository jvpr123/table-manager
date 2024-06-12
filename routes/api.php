<?php

use App\Http\Controllers\LocalController;
use Illuminate\Support\Facades\Route;

Route::controller(LocalController::class)->group(function () {
    Route::post('/', 'store')->name('store-local');
    Route::get('/{localId}', 'show')->name('get-local');
})->prefix('local');
