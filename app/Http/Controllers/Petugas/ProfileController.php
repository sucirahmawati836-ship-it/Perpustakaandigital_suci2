<?php

namespace App\Http\Controllers\Petugas;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('petugas.profile.index');
    }

    public function edit()
    {
        return view('petugas.profile.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('petugas.profile.index')->with('success', 'Profile berhasil diupdate!');
    }
}