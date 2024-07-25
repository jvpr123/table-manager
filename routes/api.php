<?php

use App\Http\Controllers\LocalController;
use Illuminate\Support\Facades\Route;

Route::controller(LocalController::class)->group(function () {
    Route::post('/', 'store')->name('store-local');
    Route::get('/', 'index')->name('get-locals');
    Route::get('/{localId}', 'show')->name('get-local');
    Route::put('/{localId}', 'update')->name('update-local');
    Route::delete('/{localId}', 'delete')->name('delete-local');
})->prefix('local');
