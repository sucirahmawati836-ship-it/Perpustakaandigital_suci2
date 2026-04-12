<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Buku;
use App\Models\Peminjaman;
use Carbon\Carbon;

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
            'tanggal_jatuh_tempo' => now()->addDays(3),
            
            'status' => 'menunggu',
        ]);

        return redirect()->route('anggota.buku.index')
            ->with('success', 'Pengajuan peminjaman berhasil, menunggu konfirmasi petugas!');
    }

    public function kembalikan($id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        $tanggalPinjam = Carbon::parse($pinjam->tanggal_pinjam);
        $batasKembali = $tanggalPinjam->copy()->addDays(3);
        $hariIni = Carbon::now();

        $denda = 0;

    if ($hariIni->greaterThan($batasKembali)) {
        $terlambat = $batasKembali->diffInDays($hariIni);
        $denda = $terlambat * 2000;
    }

    $pinjam->update([
        'tanggal_kembali' => $hariIni,
        'status' => 'dikembalikan',
        'denda' => $denda
    ]);

          return redirect()->back()->with('success', 'Buku dikembalikan. Denda: Rp ' . $denda);
    }
}