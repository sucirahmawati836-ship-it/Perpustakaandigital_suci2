<?php

namespace App\Http\Controllers\Anggota;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
{
    $user = Auth::user();

    $anggota = Anggota::where('user_id', $user->id)->first();

    // bikin inisial 
    $inisial = '';
    if ($user) {
        foreach (explode(' ', $user->name) as $n) {
            $inisial .= strtoupper(substr($n, 0, 1));
        }
    }

    return view('anggota.profile.index', compact('user', 'anggota', 'inisial'));
}
public function edit()
{
    $user = auth()->user();
    return view('anggota.profile.edit', compact('user'));
}

public function update(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'nis' => 'required'
    ]);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'nis' => $request->nis
    ]);

    return redirect()->route('anggota.profile.index')
        ->with('success', 'Profile berhasil diupdate');
    }
}