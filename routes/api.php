<?php

use App\Http\Controllers\LocalController;
use App\Http\Controllers\ResponsibleController;
use Illuminate\Support\Facades\Route;

Route::controller(LocalController::class)
    ->prefix('local')
    ->group(function () {
        Route::post('/', 'store')->name('store-local');
        Route::get('/', 'index')->name('get-locals');
        Route::get('/{localId}', 'show')->name('get-local');
        Route::put('/{localId}', 'update')->name('update-local');
        Route::delete('/{localId}', 'delete')->name('delete-local');
    });

Route::controller(ResponsibleController::class)
    ->prefix('responsible')
    ->group(function () {
        Route::post('/', 'store')->name('store-responsible');
    });
