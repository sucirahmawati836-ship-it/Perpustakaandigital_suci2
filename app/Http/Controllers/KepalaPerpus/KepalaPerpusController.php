<?php

namespace App\Http\Controllers\KepalaPerpus;

use App\Models\KepalaPerpus;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class KepalaPerpusController extends Controller
{

    public function index()
    {
        // ambil 1 data kepala perpus (sementara)
        $kepala = KepalaPerpus::with('user')->first();

        // ambil inisial dari nama
        $inisial = '';
        if ($kepala && $kepala->user) {
            $nama = explode(' ', $kepala->user->name);

            foreach ($nama as $n) {
                $inisial .= strtoupper(substr($n, 0, 1));
            }
        }

        return view('kepala.profile.index', compact('kepala', 'inisial'));
    }

    public function edit($id)
{
    $kepala = KepalaPerpus::with('user')->findOrFail($id);

    return view('kepala.profile.edit', compact('kepala'));
}

public function update(Request $request, $id)
{
    $kepala = KepalaPerpus::with('user')->findOrFail($id);

    // validasi
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'nip_KepalaPerpus' => 'required',
    ]);

    // update user
    $kepala->user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    // update kepala
    $kepala->update([
        'nip_KepalaPerpus' => $request->nip_KepalaPerpus,
    ]);

    return redirect()->route('kepala.profile.index')->with('success', 'Data berhasil diupdate');
}

}