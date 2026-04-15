<?php

namespace App\Http\Controllers\KepalaPerpus;

use App\Models\KepalaPerpus;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use App\Models\Buku;
use App\Models\Peminjaman;

class KepalaPerpusController extends Controller
{
    // ================= DASHBOARD =================
    public function dashboard()
    {
        $totalAkun = User::count();
        $totalBuku = Buku::count();
        $totalPeminjaman = Peminjaman::count();
        $dipinjam = Peminjaman::where('status', 'dipinjam')->count();
        $dikembalikan = Peminjaman::where('status', 'dikembalikan')->count();
        $totalDenda = Peminjaman::sum('denda');

        $peminjamanTerbaru = Peminjaman::with('user','buku')
            ->latest()
            ->take(5)
            ->get();

        return view('kepala.dashboard', compact(
            'totalAkun',
            'totalBuku',
            'totalPeminjaman',
            'dipinjam',
            'dikembalikan',
            'totalDenda',
            'peminjamanTerbaru'
        ));
    }

    // ================= PROFILE INDEX =================
    public function index()
    {
        $user = auth()->user();

        $kepala = KepalaPerpus::where('user_id', $user->id)->first();

        // buat inisial
        $inisial = '';
        $nama = explode(' ', $user->name);

        foreach ($nama as $n) {
            $inisial .= strtoupper(substr($n, 0, 1));
        }

        return view('kepala.profile.index', compact('user', 'kepala', 'inisial'));
    }

    // ================= EDIT PROFILE  =================
    public function edit()
    {
        $user = auth()->user();

        $kepala = KepalaPerpus::where('user_id', $user->id)->first();

        return view('kepala.profile.edit', compact('user', 'kepala'));
    }

    // ================= UPDATE PROFILE  =================
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nip_kepala' => 'nullable|max:50',
        ]);

        // update user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'nip_kepala' => $request->nip_kepala,
        ]);

        // update kepala (kalau ada datanya)
        $kepala = KepalaPerpus::where('user_id', $user->id)->first();

        if ($kepala) {
            $kepala->update([
             'nip_kepala' => $request->nip_kepala,
            ]);
        }

        return redirect()->route('kepala.profile.index')
            ->with('success', 'Data berhasil diupdate');
    }
}