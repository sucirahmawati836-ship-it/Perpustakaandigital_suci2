<?php

use App\Http\Controllers\KepalaPerpus\AkunController;
use App\Http\Controllers\KepalaPerpus\BukuController;
use App\Http\Controllers\KepalaPerpus\KepalaPerpusController;
use App\Http\Controllers\Petugas\BukuController as PetugasBukuController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ROUTE KEPALA PERPUSTAKAAN
|--------------------------------------------------------------------------
*/
Route::prefix('kepala')->name('kepala.')->group(function () {

    /*
    |----------------------------------
    | DASHBOARD
    |----------------------------------
    */
    Route::view('/dashboard', 'kepala.dashboard')->name('dashboard');

    /*
    |----------------------------------
    | PROFILE
    |----------------------------------
    */
    Route::get('/profile', [KepalaPerpusController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit/{id}', [KepalaPerpusController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update/{id}', [KepalaPerpusController::class, 'update'])->name('update');

    /*
    |----------------------------------
    | MANAJEMEN AKUN
    |----------------------------------
    */
    Route::prefix('akun')->name('akun.')->group(function () {

        Route::get('/', [AkunController::class, 'index'])->name('index');
        Route::get('/create', [AkunController::class, 'create'])->name('create');
        Route::post('/store', [AkunController::class, 'store'])->name('store');

        Route::get('/{id}/detail', [AkunController::class, 'detail'])->name('detail');
        Route::get('/{id}/edit', [AkunController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [AkunController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [AkunController::class, 'destroy'])->name('destroy');
    });

    /*
    |----------------------------------
    | MANAJEMEN BUKU
    |----------------------------------
    */
    Route::prefix('buku')->name('buku.')->group(function () {

        Route::get('/', [BukuController::class, 'index'])->name('index');
        Route::get('/create', [BukuController::class, 'create'])->name('create');
        Route::post('/store', [BukuController::class, 'store'])->name('store');

        Route::get('/{buku}/edit', [BukuController::class, 'edit'])->name('edit');
        Route::put('/{buku}/update', [BukuController::class, 'update'])->name('update');
        Route::delete('/{buku}/delete', [BukuController::class, 'destroy'])->name('destroy');
    });

});

/*
|--------------------------------------------------------------------------
| ROUTE PETUGAS
|--------------------------------------------------------------------------
*/
Route::prefix('buku')->name('petugas.buku.')->group(function () {

    Route::get('/', [PetugasBukuController::class, 'index'])->name('index');
    Route::get('/create', [PetugasBukuController::class, 'create'])->name('create');
    Route::post('/store', [PetugasBukuController::class, 'store'])->name('store');

    Route::get('/{buku}/edit', [PetugasBukuController::class, 'edit'])->name('edit');
    Route::put('/{buku}/update', [PetugasBukuController::class, 'update'])->name('update');
    Route::delete('/{buku}/delete', [PetugasBukuController::class, 'destroy'])->name('destroy');
});


/*
|--------------------------------------------------------------------------
| LOGOUT (TAMBAHAN)
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');})->name('logout'); // bisa diganti ke /login kalau ada
