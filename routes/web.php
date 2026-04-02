<?php

use App\Http\Controllers\AkunController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('akun.index');
});

// Route untuk Akun
Route::resource('akun', AkunController::class)->except(['show']);
Route::get('akun/{id}/detail', [AkunController::class, 'detail'])->name('akun.detail');