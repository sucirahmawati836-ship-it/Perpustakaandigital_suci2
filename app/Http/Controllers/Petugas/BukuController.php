<?php

namespace App\Http\Controllers\Petugas;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $buku = Buku::all();
        return view('petugas.buku.index', compact('buku'));
    }

    public function create()
    {
        return view('petugas.buku.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_buku'    => 'required|unique:buku,kode_buku',
            'judul_buku'   => 'required',
            'penulis'      => 'required',
            'sinopsis'     => 'nullable',
            'tahun_terbit' => 'required|integer|min:1000|max:' . date('Y'),
            'stok'         => 'required|integer|min:0',
            'cover'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Ubah tahun jadi format DATE (YYYY-01-01)
        $validated['tahun_terbit'] = $validated['tahun_terbit'] . '-01-01';

        // Upload gambar
        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Buku::create($validated);

        return redirect()->route('petugas.buku.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit(Buku $buku)
    {
        return view('petugas.buku.edit', ["buku" => $buku]);
    }

    public function update(Request $request, Buku $buku)
    {   
        $validated = $request->validate([
            'kode_buku'    => 'required|unique:buku,kode_buku,' . $buku->id,
            'judul_buku'   => 'required',
            'penulis'      => 'required',
            'tahun_terbit' => 'required|integer|min:1000|max:' . date('Y'),
            'sinopsis'     => 'nullable',
            'stok'         => 'required|integer|min:0',
            'cover'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Ubah tahun jadi format DATE
        $validated['tahun_terbit'] = $validated['tahun_terbit'] . '-01-01';

        // Hapus gambar lama jika ada
        if ($request->hasFile('cover')) {
            if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
                Storage::disk('public')->delete($buku->cover);
            }

            // Upload gambar baru
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku->update($validated);

        return redirect()->route('petugas.buku.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy(Buku $buku)
    {
        // Hapus gambar lama jika ada
        if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
            Storage::disk('public')->delete($buku->cover);
        }

        //  perbaikan delete
        $buku->delete();

        return redirect()->route('petugas.buku.index')->with('success', 'Data berhasil dihapus');
    }
}