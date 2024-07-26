<?php

use App\Http\Controllers\LocalController;
use App\Http\Controllers\PeriodController;
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
        Route::get('/', 'index')->name('get-responsibles');
        Route::get('/{responsibleId}', 'show')->name('get-responsible');
        Route::put('/{responsibleId}', 'update')->name('update-responsible');
        Route::delete('/{responsibleId}', 'delete')->name('delete-responsible');
    });

Route::controller(PeriodController::class)
    ->prefix('period')
    ->group(function () {
        Route::post('/', 'store')->name('store-period');
        Route::get('/', 'index')->name('get-periods');
        Route::get('/{periodId}', 'show')->name('get-period');
        Route::put('/{periodId}', 'update')->name('update-period');
        Route::delete('/{periodId}', 'delete')->name('delete-period');
    });
