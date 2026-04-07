<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Buku;
use App\Models\Peminjaman;

class PetugasController extends Controller
{
    // ================= DASHBOARD =================
    public function dashboard()
    {
        $totalBuku = Buku::count();
        $pinjamanAktif = Peminjaman::where('status', 'dipinjam')->count();
        $peminjaman = Peminjaman::where('status', 'menunggu')->count(); // 

        return view('petugas.dashboard', compact('totalBuku', 'pinjamanAktif', 'peminjaman'));
    }

    // ================= PROFILE =================
    public function profile()
    {
        $petugas = Auth::user();
        return view('petugas.profile.index', compact('petugas'));
    }

    // ================= EDIT PROFILE =================
    public function editProfile()
    {
        $petugas = Auth::user();
        return view('petugas.edit_profile', compact('petugas'));
    }

    public function updateProfile(Request $request)
    {
        $petugas = Auth::user();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $petugas->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('petugas.profile')->with('success', 'Data berhasil diupdate');
    }

    // ================= PEMINJAMAN =================
    public function peminjaman()
    {
        $peminjamanList = Peminjaman::where('status', 'menunggu')->get(); 

        return view('petugas.peminjaman.index', compact('peminjamanList')); 
    }

    // ================= ACC PEMINJAMAN =================
    public function acc($id)
    {
        $pinjam = Peminjaman::with('buku')->findOrFail($id);

        $pinjam->status = 'dipinjam';
        $pinjam->save();

        // kurangi stok
        $pinjam->buku->decrement('stok');

        return back()->with('success', 'Peminjaman berhasil disetujui');
    }

    // ================= PENGEMBALIAN =================
    public function pengembalian()
    {
        $pengembalianList = Peminjaman::where('status', 'dipinjam')->get();

        return view('petugas.pengembalian', compact('pengembalianList'));
    }

    // ================= DAFTAR BUKU =================
    public function daftarBuku()
    {
        $bukuList = Buku::all();
        return view('petugas.daftar_buku', compact('bukuList'));
    }
}