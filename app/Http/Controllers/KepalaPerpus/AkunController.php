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
        // Validasi Dasar (Berlaku untuk semua role)
        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role'    => 'required|in:anggota,petugas,kepala',
        ];

        // Validasi Dinamis berdasarkan role
        if ($request->role == 'anggota') {
            $rules['nis']   = 'required|unique:anggota,nis';
            $rules['kelas'] = 'required';
        } 
        elseif ($request->role == 'petugas') {
            $rules['nip_petugas']   = 'nullable|unique:petugas,nip_petugas';
            $rules['no_hp'] = 'nullable';
        } 
        elseif ($request->role == 'kepala') {
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
                'role'    => $request->role,
            ]);

            // 2. Simpan Data ke Tabel Profil Berdasarkan role
            if ($request->role == 'anggota') {
                Anggota::create([
                    'user_id' => $user->id,
                    'nis'     => $request->nis,
                    'kelas'   => $request->kelas,
                    'alamat'  => $request->alamat,
                ]);
            } 
            elseif ($request->role == 'petugas') {
                Petugas::create([
                    'user_id' => $user->id,
                    'nip_petugas'     => $request->nip_petugas,
                    'no_hp'   => $request->no_hp,
                ]);
            } 
            elseif ($request->role == 'kepala') {
                KepalaPerpus::create([
                    'user_id' => $user->id,
                    'nip_KepalaPerpus'     => $request->nip_KepalaPerpus,
                ]);
            }

            DB::commit();
            return redirect()->route('kepala.akun.index')->with('success', 'Akun ' . $request->role . ' berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan akun: ' . $e->getMessage()]);
        }
    }

    // FORM EDIT AKUN
    public function edit($id)
    {
        $user = User::findOrFail($id);
        
        // Ambil data profilnya berdasarkan role
        if ($user->role == 'anggota') {
            $user->load('anggota');
        } elseif ($user->role == 'petugas') {
            $user->load('petugas');
        } elseif ($user->role == 'kepala') {
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

        if ($user->role == 'anggota') {
            $rules['nis']   = 'required|unique:anggota,nis,' . $user->anggota->id;
            $rules['kelas'] = 'required';
        } elseif ($user->role == 'petugas') {
            $rules['nip_petugas']   = 'nullable|unique:petugas,nip_petugas,' . $user->petugas->id;
        } elseif ($user->role == 'kepala') {
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
            if ($user->role == 'anggota') {
                $user->anggota->update([
                    'nis'    => $request->nis,
                    'kelas'  => $request->kelas,
                    'alamat' => $request->alamat,
                ]);
            } elseif ($user->role == 'petugas') {
                $user->petugas->update([
                    'nip_petugas'   => $request->nip_petugas,
                    'no_hp' => $request->no_hp,
                ]);
            } elseif ($user->role == 'kepala') {
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

    if ($user->role == 'anggota') {
        $user->load('anggota');
    } elseif ($user->role == 'petugas') {
        $user->load('petugas');
    } elseif ($user->role == 'kepala') {
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