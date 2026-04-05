<?php

namespace App\Http\Controllers\KepalaPerpus;

use App\Models\Anggota;
use App\Models\KepalaPerpus;
use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    // MENAMPILKAN SEMUA AKUN
    public function index()
    {
        // Mengambil semua user, urutkan terbaru
        $users = User::orderBy('created_at', 'desc')->get();
        return view('kepala.akun.index', compact('users'));
    }

    // FORM TAMBAH AKUN
    public function create()
    {
        return view('kepala.akun.create');
    }

    // SIMPAN KE DATABASE (LOGIKA DINAMIS)
    public function store(Request $request)
    {
        // Validasi Dasar (Berlaku untuk semua level)
        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'level'    => 'required|in:anggota,petugas,kepala',
        ];

        // Validasi Dinamis berdasarkan Level
        if ($request->level == 'anggota') {
            $rules['nis']   = 'required|unique:anggota,nis';
            $rules['kelas'] = 'required';
        } 
        elseif ($request->level == 'petugas') {
            $rules['nip_petugas']   = 'nullable|unique:petugas,nip_petugas';
            $rules['no_hp'] = 'nullable';
        } 
        elseif ($request->level == 'kepala') {
            $rules['nip_KepalaPerpus']   = 'nullable|unique:kepala_perpus,nip_KepalaPerpus';
        }

        $request->validate($rules);

        // MULAI TRANSACTION
        DB::beginTransaction();
        try {
            // 1. Buat Akun User Terlebih Dahulu
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'level'    => $request->level,
            ]);

            // 2. Simpan Data ke Tabel Profil Berdasarkan Level
            if ($request->level == 'anggota') {
                Anggota::create([
                    'user_id' => $user->id,
                    'nis'     => $request->nis,
                    'kelas'   => $request->kelas,
                    'alamat'  => $request->alamat,
                ]);
            } 
            elseif ($request->level == 'petugas') {
                Petugas::create([
                    'user_id' => $user->id,
                    'nip_petugas'     => $request->nip_petugas,
                    'no_hp'   => $request->no_hp,
                ]);
            } 
            elseif ($request->level == 'kepala') {
                KepalaPerpus::create([
                    'user_id' => $user->id,
                    'nip_KepalaPerpus'     => $request->nip_KepalaPerpus,
                ]);
            }

            DB::commit();
            return redirect()->route('kepala.akun.index')->with('success', 'Akun ' . $request->level . ' berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan akun: ' . $e->getMessage()]);
        }
    }

    // FORM EDIT AKUN
    public function edit($id)
    {
        $user = User::findOrFail($id);
        
        // Ambil data profilnya berdasarkan level
        if ($user->level == 'anggota') {
            $user->load('anggota');
        } elseif ($user->level == 'petugas') {
            $user->load('petugas');
        } elseif ($user->level == 'kepala') {
            $user->load('kepala');
        }

        return view('kepala.akun.edit', compact('user'));
    }

    // UPDATE DATABASE
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ];

        if ($user->level == 'anggota') {
            $rules['nis']   = 'required|unique:anggota,nis,' . $user->anggota->id;
            $rules['kelas'] = 'required';
        } elseif ($user->level == 'petugas') {
            $rules['nip_petugas']   = 'nullable|unique:petugas,nip_petugas,' . $user->petugas->id;
        } elseif ($user->level == 'kepala') {
            $rules['nip_KepalaPerpus']   = 'nullable|unique:kepala_perpus,nip_KepalaPerpus,' . $user->kepala->id;
        }

        $request->validate($rules);

        DB::beginTransaction();
        try {
            // 1. Update Data User
            $user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);

            // 2. Update Data Profil
            if ($user->level == 'anggota') {
                $user->anggota->update([
                    'nis'    => $request->nis,
                    'kelas'  => $request->kelas,
                    'alamat' => $request->alamat,
                ]);
            } elseif ($user->level == 'petugas') {
                $user->petugas->update([
                    'nip_petugas'   => $request->nip_petugas,
                    'no_hp' => $request->no_hp,
                ]);
            } elseif ($user->level == 'kepala') {
                $user->kepala->update([
                    'nip_KepalaPerpus' => $request->nip_KepalaPerpus,
                ]);
            }

            DB::commit();
            return redirect()->route('kepala.akun.index')->with('success', 'Akun berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal update akun']);
        }
    }

    //DETAIL AKUN
    public function detail($id)
{
    $user = User::findOrFail($id);

    if ($user->level == 'anggota') {
        $user->load('anggota');
    } elseif ($user->level == 'petugas') {
        $user->load('petugas');
    } elseif ($user->level == 'kepala') {
        $user->load('kepala');
    }

    return view('kepala.akun.view', compact('user'));
}

    // HAPUS AKUN
    public function destroy($id)
    {
        // Karena pakai cascadeOnDelete() di migration, 
        // menghapus user OTOMATIS menghapus data anggota/petugas/kepalanya
        User::destroy($id);
        return redirect()->route('kepala.akun.index')->with('success', 'Akun berhasil dihapus!');
    }
}