<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Petugas;
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
        $petugas = Petugas::with('user')->first();

        $inisial = '';
        if ($petugas && $petugas->user) {
            $nama = explode(' ', $petugas->user->name);

            foreach ($nama as $n) {
                $inisial .= strtoupper(substr($n, 0, 1));
            }
        }

        return view('petugas.profile.index', compact('petugas', 'inisial'));
    }

    // ================= EDIT PROFILE =================
    public function edit($id)
    {
        $petugas = petugas::with('user')->findOrFail($id);

        return view('petugas.profile.edit', compact('petugas'));
    }

    public function update(Request $request, $id)
    {
        $petugas = petugas::with('user')->findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'nip_petugas' => 'required',
        ]);

        $petugas->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $petugas->update([
            'nip_petugas' => $request->nip_petugas,
        ]);

        return redirect()->route('petugas.profile.index')->with('success', 'Data berhasil diupdate');
    }

    // ================= PEMINJAMAN =================
    public function peminjaman()
    {
        $peminjamanList = Peminjaman::with(['user', 'buku'])
            ->where('status', 'menunggu')
            ->get();

        return view('petugas.peminjaman.index', compact('peminjamanList'));
    }

    // ================= ACC PEMINJAMAN =================
    public function acc($id)
    {
        $pinjam = Peminjaman::with('buku')->findOrFail($id);

        $pinjam->status = 'dipinjam';
        $pinjam->tanggal_jatuh_tempo = now()->addDays(3);
        $pinjam->save();

    // kurangi stok buku
        $pinjam->buku->decrement('stok');

    // ================= NOTIFIKASI DISETUJUI PINJAM =================
    Notifikasi::create([
        'user_id' => $pinjam->user_id,
        'pesan' => 'Peminjaman buku disetujui',
        'dibaca' => false,
    ]);

       return back()->with('success', 'Peminjaman berhasil disetujui');
    }

    // ================= TOLAK PEMINJAMAN =================
    public function tolak(Request $request, $id)
    {
    $pinjam = Peminjaman::findOrFail($id);

    $request->validate([
        'alasan' => 'required'
    ]);

    $pinjam->update([
        'status' => 'ditolak',
        'alasan_penolakan' => $request->alasan
    ]);

        // ================= NOTIFIKASI TOLAK PINJAM =================
        Notifikasi::create([
        'user_id' => $pinjam->user_id,
        'pesan' => 'Peminjaman ditolak: ' . $request->alasan,
        'dibaca' => false,
    ]);
        return back()->with('success', 'Peminjaman berhasil ditolak');
    }

    // ================= PENGEMBALIAN =================
    public function pengembalian()
    {
    $pengembalianList = Peminjaman::with(['user', 'buku'])
        ->whereIn('status', ['dipinjam', 'dikembalikan'])
        ->get();

       return view('petugas.pengembalian.index', compact('pengembalianList'));
    }
    // ================= PROSES PENGEMBALIAN =================
    public function kembalikan(Request $request, $id)
    {
      $pinjam = Peminjaman::with('buku')->findOrFail($id);

      $today = Carbon::now();
      $jatuhTempo = Carbon::parse($pinjam->tanggal_jatuh_tempo);

      $denda = 0;
      $jenisDenda = null;

      $pilihan = $request->jenis_denda ?? 'normal';

    if ($pilihan == 'hilang') {
        $denda = 100000;
        $jenisDenda = 'hilang';

    } elseif ($pilihan == 'rusak') {
        $denda = 50000;
        $jenisDenda = 'rusak';

    } else {
        // default = cek keterlambatan
        if ($today->greaterThan($jatuhTempo)) {
            $terlambat = $today->diffInDays($jatuhTempo);
            $denda = $terlambat * 1000;
            $jenisDenda = 'terlambat';
        }
    }

    $pinjam->update([
        'status' => 'dikembalikan',
        'tanggal_kembali' => $today,
        'denda' => $denda,
        'jenis_denda' => $jenisDenda,
        'status_denda' => $denda > 0 ? 'belum_bayar' : 'lunas'
    ]);

       $pinjam->buku->increment('stok');

       return back()->with('success', 'Buku berhasil dikembalikan');
    }

    // ================= DAFTAR BUKU =================
    public function daftarbuku()
    {
        $bukuList = Buku::all();
        return view('petugas.buku.index', compact('bukuList'));
    }

    // ================= NOTIFIKASI =================
    public function notifikasi()
    {
        $notifikasi = Notifikasi::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('anggota.notifikasi.index', compact('notifikasi'));
    }

    // ================= VERIFIKASI PEMBAYARAN=================
    public function verifikasi($id)
    {
      $p = Peminjaman::findOrFail($id);

      $p->update([
        'status_denda' => 'lunas',
        'tanggal_bayar' => now(),
    ]);

      return back();
  }
}