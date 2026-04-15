<?php

namespace App\Http\Controllers\KepalaPerpus;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;

class LaporanController extends Controller
{
    public function index()
    {
        // PEMINJAMAN
        $peminjaman = Peminjaman::with(['user','buku'])
            ->where('status', 'dipinjam')
            ->get();

        // PENGEMBALIAN
        $pengembalian = Peminjaman::with(['user','buku'])
            ->where('status', 'dikembalikan')
            ->get();

        // DENDA
        $denda = Peminjaman::with(['user','buku'])
            ->where('denda', '>', 0)
            ->get();

        return view('kepala.laporan.index', compact(
            'peminjaman',
            'pengembalian',
            'denda'
        ));
    }
}