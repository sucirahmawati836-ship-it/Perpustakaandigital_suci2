<?php

namespace App\Http\Controllers\KepalaPerpus;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('kepala.profile.index');
    }

    public function edit()
    {
        return view('kepala.profile.edit');
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

        return redirect()->route('kepala.profile.index')->with('success', 'Profile berhasil diupdate!');
    }
}