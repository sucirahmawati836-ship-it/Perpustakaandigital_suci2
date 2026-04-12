<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Notifikasi; 

class AnggotaController extends Controller
{
    // ================= DASHBOARD =================
    public function dashboard()
    {
      $user = Auth::user();

      $totalBuku = Buku::count();

      $bukuDipinjam = Peminjaman::where('user_id', $user->id)
        ->where('status', 'dipinjam')
        ->count();

      $jumlahNotifikasi = Notifikasi::where('user_id', Auth::id())
        ->where('dibaca', false)
        ->count();

      $bukuTerbaru = Buku::latest()->take(6)->get();

   
      $riwayat = Peminjaman::with('buku')
        ->where('user_id', $user->id)
        ->latest()
        ->take(5)
        ->get();

    return view('anggota.dashboard', compact(
        'totalBuku',
        'bukuDipinjam',
        'jumlahNotifikasi',
        'bukuTerbaru',
        'riwayat'
     ));
    }
    // ================= RIWAYAT PEMINJAMAN =================
    public function riwayat()
    {
        $peminjamanList = Peminjaman::where('user_id', auth()->id())
            ->with('buku')
            ->latest()
            ->get();

        return view('anggota.riwayat', compact('peminjamanList'));
    }

    // ================= DAFTAR BUKU =================
    public function katalog()
    {
        $bukuList = Buku::all();
        return view('anggota.buku.index', compact('bukuList'));
    }

    // ================= PROFILE =================
    public function index()
    {
        $anggota = Anggota::with('user')->first();

        $inisial = '';
        if ($anggota && $anggota->user) {
            $nama = explode(' ', $anggota->user->name);

            foreach ($nama as $n) {
                $inisial .= strtoupper(substr($n, 0, 1));
            }
        }

        return view('anggota.profile.index', compact('anggota', 'inisial'));
    }

    // ================= EDIT PROFILE =================
    public function edit($id)
    {
        $anggota = Anggota::with('user')->findOrFail($id);

        return view('anggota.profile.edit', compact('anggota'));
    }

    // ================= UPDATE PROFILE =================
    public function update(Request $request, $id)
    {
        $anggota = Anggota::with('user')->findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'nis' => 'required',
        ]);

        $anggota->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $anggota->update([
            'nis' => $request->nis,
        ]);

        return redirect()->route('anggota.profile.index')
            ->with('success', 'Data berhasil diupdate');
    }

    // ================= NOTIFIKASI =================
    public function notifikasi()
    {
     $user = Auth::user();

    // Ambil semua notifikasi 
     $notifikasi = Notifikasi::where('user_id', $user->id)
        ->latest()
        ->get();

    // Jumlah yang belum dibaca
     $jumlahNotifikasi = Notifikasi::where('user_id', $user->id)
        ->where('dibaca', false)
        ->count();

    // Tandai otomatis jadi dibaca saat halaman dibuka
    Notifikasi::where('user_id', $user->id)
        ->where('dibaca', false)
        ->update(['dibaca' => true]);

      return view('anggota.notifikasi.index', compact('notifikasi', 'jumlahNotifikasi'));
    }

    // ================= (RIWAYAT PEMBAYARAN DETAIL) =================
    public function riwayatPembayaran()
    {
        $peminjamanList = Peminjaman::where('user_id', auth()->id())
            ->whereNotNull('metode_pembayaran') // hanya yang sudah bayar
            ->with('buku')
            ->latest()
            ->get();

        return view('anggota.riwayat_pembayaran', compact('peminjamanList'));
    }

    // ================= PROSES BAYAR DENDA =================
    public function bayar(Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran' => 'required'
        ]);

        $p = Peminjaman::findOrFail($id);

        $p->update([
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_denda' => 'menunggu_verifikasi'
        ]);

        return back()->with('success', 'Pembayaran berhasil dikirim');
    }
}