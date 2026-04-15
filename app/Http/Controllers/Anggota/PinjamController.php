<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;
use Carbon\Carbon;

class PinjamController extends Controller
{
    // ================= PINJAM BUKU =================
    public function store(Buku $buku)
    {
        $user = Auth::user();

        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku habis!');
        }

        Peminjaman::create([
            'user_id' => $user->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => now(),
            'tanggal_jatuh_tempo' => now()->addDays(5),
            'status' => 'menunggu',
        ]);

        return redirect()->route('anggota.buku.index')
            ->with('success', 'Pengajuan peminjaman berhasil, menunggu konfirmasi petugas!');
    }

    // ================= PENGEMBALIAN BUKU =================
    public function kembalikan(Request $request, $id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        // ================= TANGGAL =================
        $kembali = Carbon::now()->startOfDay();
        $batas   = Carbon::parse($pinjam->tanggal_jatuh_tempo)->startOfDay();

        // ================= DENDA TELAT =================
        $terlambat = $kembali->gt($batas)
            ? $batas->diffInDays($kembali)
            : 0;

        $denda = $terlambat * 1000;

        // ================= KONDISI BUKU =================
        $kondisi = $request->jenis_denda ?? 'baik';

        if ($kondisi == 'rusak') {
            $denda += 50000;
        } elseif ($kondisi == 'hilang') {
            $denda += 100000;
        }

// ================= UPDATE PEMINJAMAN =================
        $pinjam->update([
    'tanggal_kembali' => now(),
    'status' => 'dikembalikan',
    'denda' => $denda,
    'kondisi_buku' => $kondisi,
    'status_denda' => $denda > 0 ? 'menunggu_verifikasi' : 'tidak_ada'
]);

// ================= KEMBALIKAN STOK =================
    $buku = Buku::find($pinjam->buku_id);

  if ($buku) {
    $buku->increment('stok');
}
      return back()->with('success', 'Buku berhasil dikembalikan. Total denda: Rp ' . number_format($denda));
    }
}