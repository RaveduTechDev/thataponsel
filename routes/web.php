<?php

use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('dashboard');

    Route::prefix('master-data')->name('master-data.')->group(function () {
        Route::get('/', [MasterDataController::class, 'index'])->name('index');
        Route::resource('pelanggan', PelangganController::class);
    });
    Route::resource('stocks', StockController::class);
});
