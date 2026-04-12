<?php

namespace App\Http\Controllers\KepalaPerpus;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;

class LaporanController extends Controller
{
    public function index()
    {
       $pengembalian = Peminjaman::with(['user','buku'])
            ->where('status', 'dikembalikan')
            ->get();
        return view('kepala.laporan.index', compact('pengembalian'));
    }
}