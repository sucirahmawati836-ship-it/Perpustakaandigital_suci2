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

        $jumlahNotifikasi = Notifikasi::where('user_id', $user->id)
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

    // ================= RIWAYAT =================
    public function riwayat()
    {
        $peminjamanList = Peminjaman::where('user_id', auth()->id())
            ->with('buku')
            ->latest()
            ->get();

        return view('anggota.riwayat', compact('peminjamanList'));
    }

    // ================= KATALOG =================
    public function katalog()
    {
        $bukuList = Buku::all();
        return view('anggota.buku.index', compact('bukuList'));
    }

    // ================= PROFILE =================
    public function index()
    {
        $user = Auth::user();

        $anggota = Anggota::where('user_id', $user->id)->first();

        $inisial = '';
        foreach (explode(' ', $user->name) as $n) {
            $inisial .= strtoupper(substr($n, 0, 1));
        }

        return view('anggota.profile.index', compact('user', 'anggota', 'inisial'));
    }

    public function edit()
    {
        $user = Auth::user();

        $anggota = Anggota::firstOrCreate(
            ['user_id' => $user->id],
            ['nis' => '', 'kelas' => '', 'alamat' => '']
        );

        return view('anggota.profile.edit', compact('user', 'anggota'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $anggota = Anggota::firstOrCreate(
            ['user_id' => $user->id],
            ['nis' => '', 'kelas' => '', 'alamat' => '']
        );

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nis' => 'required'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $anggota->update([
            'nis' => $request->nis
        ]);

        return redirect()->route('anggota.profile.index')
            ->with('success', 'Profile berhasil diupdate');
    }

    // ================= NOTIFIKASI =================
    public function notifikasi()
    {
        $user = Auth::user();

        $notifikasi = Notifikasi::where('user_id', $user->id)
            ->latest()
            ->get();

        Notifikasi::where('user_id', $user->id)
            ->where('dibaca', false)
            ->update(['dibaca' => true]);

        $jumlahNotifikasi = Notifikasi::where('user_id', $user->id)
            ->where('dibaca', false)
            ->count();

        return view('anggota.notifikasi.index', compact('notifikasi', 'jumlahNotifikasi'));
    }

    // ================= RIWAYAT PEMBAYARAN =================
    public function riwayatPembayaran()
    {
        $peminjamanList = Peminjaman::where('user_id', auth()->id())
            ->whereNotNull('metode_pembayaran')
            ->with('buku')
            ->latest()
            ->get();

        return view('anggota.riwayat_pembayaran', compact('peminjamanList'));
    }

    // ================= BAYAR DENDA  =================
    public function bayar(Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran' => 'required'
        ]);

        $p = Peminjaman::findOrFail($id);

        //  tidak boleh bayar kalau tidak ada denda
        if (($p->denda ?? 0) <= 0) {
            return back()->with('error', 'Tidak ada denda');
        }

        //  sudah lunas
        if ($p->status_denda === 'lunas') {
            return back()->with('error', 'Sudah dibayar');
        }

        // sudah menunggu
        if ($p->status_denda === 'menunggu_verifikasi') {
            return back()->with('error', 'Sedang menunggu verifikasi petugas');
        }

        //  kirim ke petugas
        $p->update([
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_denda' => 'menunggu_verifikasi',
            'tanggal_bayar' => now()
        ]);

        return back()->with('success', 'Pembayaran berhasil dikirim, menunggu verifikasi petugas');
    }
}