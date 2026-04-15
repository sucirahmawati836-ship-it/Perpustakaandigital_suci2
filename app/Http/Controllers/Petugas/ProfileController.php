<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // ================= INDEX =================
    public function index()
    {
        $user = Auth::user();

        return view('petugas.profile.index', compact('user'));
    }

    // ================= EDIT =================
    public function edit()
    {
        $user = Auth::user();

        return view('petugas.profile.edit', compact('user'));
    }

    // ================= UPDATE =================
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nip_petugas'   => 'nullable|max:50',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'nip_petugas'   => $request->nip_petugas,
        ]);

        return redirect()->route('petugas.profile.index')
            ->with('success', 'Profile berhasil diupdate!');
    }
}