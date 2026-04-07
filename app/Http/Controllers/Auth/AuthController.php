<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ================= LOGIN =================
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // validasi
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // proses login
        if (Auth::attempt($request->only('email', 'password'))) {

            $request->session()->regenerate();

            $user = Auth::user();

            // redirect berdasarkan role
            if ($user->role == 'kepala') {
                return redirect('/kepala/dashboard');
            } elseif ($user->role == 'petugas') {
                return redirect('/petugas/dashboard');
            } else {
                return redirect('/anggota/dashboard'); 
            }
        }

        return back()->with('error', 'Email atau password salah');
    }

    // ================= REGISTER =================
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // validasi
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|confirmed',
        ]);

        // simpan user (default anggota)
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'anggota',
            'password' => Hash::make($request->password),
        ]);

        return redirect('/auth/login')->with('success', 'Register berhasil, silakan login');
    }

    // ================= LOGOUT =================
    public function logout(Request $request)
    {
        Auth::logout();

        // untuk bersihin session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/auth/login');
    }
}