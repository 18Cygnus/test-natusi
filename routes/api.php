<?php

use App\Http\Controllers\Api\PesananController;
use App\Http\Controllers\Api\StokObatController;
use Illuminate\Support\Facades\Route;

Route::prefix('pesanan')->controller(PesananController::class)->group(function (): void {
    Route::get('/', 'index')->name('api.pesanan.index');
    Route::post('/', 'store')->name('api.pesanan.store');
    Route::get('/{id}', 'show')->name('api.pesanan.show');
});

Route::prefix('obat')->controller(StokObatController::class)->group(function (): void {
    Route::get('/', 'index')->name('api.obat.index');
    Route::get('/{id}', 'show')->name('api.obat.show');
});
