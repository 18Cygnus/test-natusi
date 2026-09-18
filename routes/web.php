<?php

use App\Http\Controllers\DistributorController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('obat.index');
});

Route::resource('obat', ObatController::class);

Route::get('transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::get('transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
Route::post('transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::get('transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');
Route::get('transaksi/{transaksi}/cetak', [TransaksiController::class, 'cetak'])->name('transaksi.cetak');

Route::prefix('laporan')->name('laporan.')->group(function (): void {
    Route::get('/stok', [LaporanController::class, 'stok'])->name('stok');
    Route::get('/penjualan', [LaporanController::class, 'penjualan'])->name('penjualan');
});

Route::get('distributor/map', [DistributorController::class, 'map'])->name('distributor.map');
Route::resource('distributor', DistributorController::class);
