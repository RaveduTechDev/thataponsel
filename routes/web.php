<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\JasaIMEIController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\TokoCabangController;

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('master-data')->name('master-data.')->group(function () {
        Route::get('/', [MasterDataController::class, 'index'])->name('index');
        Route::resource('pelanggan', PelangganController::class);
        Route::resource('toko-cabang', TokoCabangController::class)->middleware('role:super_admin|admin');
        Route::resource('barang', BarangController::class);
        Route::resource('agent', UserController::class);
    });
    Route::resource('stocks', StockController::class);
    Route::get('/rekap', [RekapController::class, 'rekapPenjualan'])->name('rekap');
    Route::get('/rekap/agen', [RekapController::class, 'rekapPenjualanAgen'])->name('rekap.agen');
    Route::resource('penjualan', PenjualanController::class);
    Route::post('/penjualan/download', [ExportController::class, 'export'])->name('penjualan.export');
    Route::resource('jasa-imei', JasaIMEIController::class);
});
