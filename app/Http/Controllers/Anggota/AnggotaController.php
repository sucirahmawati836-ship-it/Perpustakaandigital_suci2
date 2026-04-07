<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Buku;
use App\Models\Peminjaman;

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

    $jumlahNotifikasi = Peminjaman::where('user_id', $user->id)
        ->where('status', 'pengajuan')
        ->count();

    $bukuTerbaru = Buku::latest()->take(6)->get();

    return view('anggota.dashboard', compact(
        'totalBuku',
        'bukuDipinjam',
        'jumlahNotifikasi',
        'bukuTerbaru'
      ));
    }
    // ================= RIWAYAT PEMINJAMAN =================
    public function riwayat()
    {
        $riwayat = Auth::user()->peminjaman()->get();
        return view('anggota.riwayat', compact('riwayat'));
    }

    // ================= DAFTAR BUKU =================
    public function daftarBuku()
    {
        $bukuList = Buku::all();
        return view('anggota.daftar_buku', compact('bukuList'));
    }

    // ================= PROFILE =================
    public function profile()
    {
        $anggota = Auth::user();
        return view('anggota.profile', compact('anggota'));
    }

    // ================= EDIT PROFILE =================
    public function editProfile()
    {
        $anggota = Auth::user();
        return view('anggota.edit_profile', compact('anggota'));
    }

    public function updateProfile(Request $request)
    {
        $anggota = Auth::user();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $anggota->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('anggota.profile')->with('success', 'Data berhasil diupdate');
    }
}