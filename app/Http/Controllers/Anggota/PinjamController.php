<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Buku;
use App\Models\Peminjaman;

class PinjamController extends Controller
{
    public function store(Buku $buku)
    {
        $user = Auth::user();

        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku habis!');
        }


        // Simpan sebagai pengajuan (menunggu)
        Peminjaman::create([
            'user_id' => $user->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => now(),
            'status' => 'menunggu',
        ]);

        return redirect()->route('anggota.buku.index')
            ->with('success', 'Pengajuan peminjaman berhasil, menunggu konfirmasi petugas!');
    }
}