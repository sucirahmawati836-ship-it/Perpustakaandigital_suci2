<?php

use App\Http\Controllers\KepalaPerpus\AkunController;
use App\Http\Controllers\KepalaPerpus\BukuController;
use App\Http\Controllers\KepalaPerpus\KepalaPerpusController;
use App\Http\Controllers\KepalaPerpus\LaporanController;
use App\Http\Controllers\Petugas\BukuController as PetugasBukuController;
use App\Http\Controllers\Petugas\ProfileController as PetugasProfile;
use App\Http\Controllers\Auth\AuthController; 
use App\Http\Controllers\Petugas\PetugasController;
use App\Http\Controllers\Anggota\AnggotaController;
use App\Http\Controllers\Anggota\BukuController as AnggotaBukuController;   
use App\Http\Controllers\Anggota\PinjamController; 
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| ROUTE AUTH 
|--------------------------------------------------------------------------
*/
Route::get('/auth/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/auth/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/auth/register', [AuthController::class, 'showRegister'])->name('auth.register'); 
Route::post('/auth/register', [AuthController::class, 'register']);


/*
|--------------------------------------------------------------------------
| ROUTE ANGGOTA 
|--------------------------------------------------------------------------
*/
Route::prefix('anggota')->middleware('auth')->name('anggota.')->group(function() {

    Route::get('dashboard', [AnggotaController::class, 'dashboard'])->name('dashboard');
    Route::get('/riwayat', [AnggotaController::class, 'riwayat'])->name('riwayat');
    Route::get('Katalog_buku', [AnggotaController::class, 'katalog'])->name('katalog');

    Route::get('/profile', [AnggotaController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [AnggotaController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [AnggotaController::class, 'update'])->name('profile.update');

    // NOTIFIKASI
    Route::get('/notifikasi', [AnggotaController::class, 'notifikasi'])->name('notifikasi.index');

    // anggota bayar
    Route::post('/bayar/{id}', [AnggotaController::class, 'bayar'])->name('bayar');
});


/*
|--------------------------------------------------------------------------
| ROUTE PETUGAS 
|--------------------------------------------------------------------------
*/
Route::prefix('petugas')->middleware('auth')->name('petugas.')->group(function() {

    Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('dashboard');

    /*
    | PEMINJAMAN
    */
    Route::get('/peminjaman', [PetugasController::class, 'peminjaman'])->name('peminjaman.index');
    Route::post('/peminjaman/{id}/terima', [PetugasController::class, 'terima'])->name('peminjaman.terima');
    Route::post('/peminjaman/{id}/tolak', [PetugasController::class, 'tolak'])->name('peminjaman.tolak');

    /*
    | PENGEMBALIAN
    */
    Route::get('/pengembalian', [PetugasController::class, 'pengembalian'])->name('pengembalian.index');
    Route::put('/pengembalian/{id}', [PetugasController::class, 'kembalikan'])->name('pengembalian.kembalikan');

    // petugas verifikasi
    Route::post('/verifikasi/{id}', [PetugasController::class, 'verifikasi'])->name('verifikasi');

    /*
    | PROFILE PETUGAS
    */
    Route::get('/profile', [PetugasController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [PetugasController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [PetugasController::class, 'update'])->name('profile.update');

    //BUKTI PEMBAYRAN
    Route::get('/petugas/struk/{id}', [PetugasController::class, 'struk'])->name('struk');

});


/*
|--------------------------------------------------------------------------
| ROUTE KEPALA PERPUSTAKAAN
|--------------------------------------------------------------------------
*/
Route::prefix('kepala')->middleware('auth')->name('kepala.')->group(function () {

    Route::get('/dashboard', [KepalaPerpusController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/profile', [KepalaPerpusController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [KepalaPerpusController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [KepalaPerpusController::class, 'update'])->name('profile.update');

    //LAPORAN
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

    /*
    | AKUN
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
    | BUKU
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
| ROUTE PETUGAS BUKU
|--------------------------------------------------------------------------
*/
Route::prefix('petugas/buku')->middleware('auth')->name('petugas.buku.')->group(function () { 

    Route::get('/', [PetugasBukuController::class, 'index'])->name('index');
    Route::get('/create', [PetugasBukuController::class, 'create'])->name('create');
    Route::post('/store', [PetugasBukuController::class, 'store'])->name('store');

    Route::get('/{buku}/edit', [PetugasBukuController::class, 'edit'])->name('edit');
    Route::put('/{buku}/update', [PetugasBukuController::class, 'update'])->name('update');
    Route::delete('/{buku}/delete', [PetugasBukuController::class, 'destroy'])->name('destroy');

});


/*
|--------------------------------------------------------------------------
| ROUTE KATALOG BUKU ANGGOTA
|--------------------------------------------------------------------------
*/
Route::prefix('anggota/buku')->middleware('auth')->name('anggota.buku.')->group(function() {

    Route::get('/', [AnggotaBukuController::class, 'index'])->name('index');          
    Route::get('/{buku}', [AnggotaBukuController::class, 'view'])->name('view');      
    Route::post('/pinjam/{buku}', [PinjamController::class, 'store'])->name('pinjam.store'); 

}); 


/*
|--------------------------------------------------------------------------
| LOGOUT 
|--------------------------------------------------------------------------
*/
Route::post('/auth/logout', function (Request $request) {
    auth()->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/auth/login'); 
})->name('logout');