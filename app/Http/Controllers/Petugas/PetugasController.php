<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Notifikasi;
use Carbon\Carbon;

class PetugasController extends Controller
{
    // ================= DASHBOARD =================
    public function dashboard()
    {
        $totalBuku = Buku::count();
        $pinjamanAktif = Peminjaman::where('status', 'dipinjam')->count();
        $peminjaman = Peminjaman::where('status', 'menunggu')->count();

        $aktivitas = Peminjaman::with(['user','buku'])
            ->latest()
            ->take(5)
            ->get();

        return view('petugas.dashboard', compact(
            'totalBuku',
            'pinjamanAktif',
            'peminjaman',
            'aktivitas'
        ));
    }

    // ================= PROFILE =================
    public function index()
    {
        $user = Auth::user();
        return view('petugas.profile.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('petugas.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nip_petugas' => 'nullable'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'nip_petugas' => $request->nip_petugas,
        ]);

        return redirect()->route('petugas.profile.index')
            ->with('success', 'Profile berhasil diupdate');
    }

    // ================= PEMINJAMAN =================
    public function peminjaman()
    {
        $peminjamanList = Peminjaman::with(['user', 'buku'])
            ->where('status', 'menunggu')
            ->latest()
            ->get();

        return view('petugas.peminjaman.index', compact('peminjamanList'));
    }

    // ================= TERIMA =================
    public function terima($id)
    {
        $pinjam = Peminjaman::with('buku')->findOrFail($id);

        if ($pinjam->buku->stok <= 0) {
            return back()->with('error', 'Stok buku habis');
        }

        $pinjam->update([
            'status' => 'dipinjam',
            'tanggal_jatuh_tempo' => now()->addDays(5),
        ]);

        $pinjam->buku->decrement('stok');

        Notifikasi::create([
            'user_id' => $pinjam->user_id,
            'pesan' => 'Peminjaman buku disetujui',
            'dibaca' => false,
        ]);

        return back()->with('success', 'Peminjaman disetujui');
    }

    // ================= TOLAK =================
    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required'
        ]);

        $pinjam = Peminjaman::findOrFail($id);

        $pinjam->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $request->alasan
        ]);

        return back()->with('success', 'Peminjaman ditolak');
    }

    // ================= PENGEMBALIAN (FIX UTAMA) =================
    public function pengembalian()
{
    $pengembalianList = Peminjaman::with(['user', 'buku'])
        ->whereIn('status', ['dipinjam', 'dikembalikan'])
        ->latest()
        ->get();

    return view('petugas.pengembalian.index', compact('pengembalianList'));
}

    // ================= KEMBALIKAN =================
    public function kembalikan(Request $request, $id)
{
    $pinjam = Peminjaman::with('buku')->findOrFail($id);
    $kondisi = $request->jenis_denda ?? 'baik';

    $kembali = Carbon::now();
    $batas = Carbon::parse($pinjam->tanggal_jatuh_tempo);

    $denda = 0;

// DENDA TERLAMBAT (FIX)

$batas = Carbon::parse($pinjam->tanggal_jatuh_tempo)->startOfDay();
$kembali = Carbon::now()->startOfDay();

$hari = 0;

if ($kembali->gt($batas)) {

    $hari = $batas->diffInDays($kembali);

    $denda += $hari * 1000;
}

    
// PASTIKAN TIDAK MINUS
    $denda = max(0, $denda);

    $pinjam->update([
        'tanggal_kembali' => $kembali,
        'status' => 'dikembalikan',
        'denda' => $denda,
        'kondisi_buku' => $kondisi,
        'status_denda' => $denda > 0 ? 'belum_bayar' : null
    ]);

    $pinjam->buku->increment('stok');

    return back()->with('success', 'Buku dikembalikan');
}

    // ================= VERIFIKASI  =================
    public function verifikasi($id)
    {
        $p = Peminjaman::findOrFail($id);

        if ($p->status_denda !== 'menunggu_verifikasi') {
            return back()->with('error', 'Tidak bisa diverifikasi');
        }

        $p->update([
            'status_denda' => 'lunas',
            'tanggal_bayar' => now(),
            'penerima' => Auth::user()->name
        ]);

        return back()->with('success', 'Pembayaran berhasil diverifikasi');
    }

    // ================= STRUK =================
    public function struk($id)
    {
        $p = Peminjaman::with(['user','buku'])->findOrFail($id);

        return view('petugas.struk', compact('p'));
    }
}