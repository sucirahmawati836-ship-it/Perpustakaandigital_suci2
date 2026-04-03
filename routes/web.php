<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Redirect Awal
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('kepala.akun.index');
});

/*
|--------------------------------------------------------------------------
| ROUTE KEPALA PERPUSTAKAAN 
|--------------------------------------------------------------------------
*/

// - MANAJEMEN AKUN
Route::prefix('akun')->name('kepala.akun.')->group(function () {

    Route::get('/', [AkunController::class, 'index'])->name('index');
    Route::get('/create', [AkunController::class, 'create'])->name('create');
    Route::post('/store', [AkunController::class, 'store'])->name('store');

    Route::get('/{id}/detail', [AkunController::class, 'detail'])->name('detail');
    Route::get('/{id}/edit', [AkunController::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [AkunController::class, 'update'])->name('update');
    Route::delete('/{id}/delete', [AkunController::class, 'destroy'])->name('destroy');

});

// - MANAJEMEN BUKU
Route::prefix('buku')->name('kepala.buku.')->group(function () {

    Route::get('/', [BukuController::class, 'index'])->name('index');
    Route::get('/create', [BukuController::class, 'create'])->name('create');
    Route::post('/store', [BukuController::class, 'store'])->name('store');

    Route::get('/{buku}/edit', [BukuController::class, 'edit'])->name('edit');
    Route::put('/{buku}/update', [BukuController::class, 'update'])->name('update');
    Route::delete('/{buku}/delete', [BukuController::class, 'destroy'])->name('destroy');

});

//DASHBOARD
    Route::get('/kepala/dashboard', [DashboardController::class, 'index'])
    ->name('kepala.dashboard');

