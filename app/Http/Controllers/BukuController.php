<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'kode_buku'    => 'required|unique:bukus,kode_buku',
            'judul_buku'   => 'required',
            'penulis'      => 'required',
            'sinopsis'     => 'nullable',
            'tahun_terbit' => 'required|date',
            'stock_buku'   => 'required|integer|min:0',
            'cover_image'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload gambar 
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        Buku::create($validated);

        return redirect()->route('buku.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit(Buku $buku)
    {
        return view('petugas.buku.edit', ["buku" => $buku]);
    }

    public function update(Request $request, Buku $buku)
    {   
        $validated = $request->validate([
            'kode_buku'    => 'required|unique:bukus,kode_buku,' . $buku->id,
            'judul_buku'   => 'required',
            'penulis'      => 'required',
            'tahun_terbit' => 'required|date',
            'sinopsis'     => 'nullable',
            'stock_buku'   => 'required|integer|min:0',
            'cover_image'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Hapus gambar lama jika ada
        if ($request->hasFile('cover_image')) {
            if ($buku->cover_image && Storage::disk('public')->exists($buku->cover_image)) {
                Storage::disk('public')->delete($buku->cover_image);
            }
        } 

        // Upload gambar baru
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $buku->update($validated);

        return redirect()->route('buku.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy(Buku $buku)
    {

    // Hapus gambar lama jika ada
        if ($buku->cover_image && Storage::disk('public')->exists($buku->cover_image)) {
        Storage::disk('public')->delete($buku->cover_image);
    }

        $buku->delete($buku->id);

        return redirect()->route('buku.index')->with('success', 'Data berhasil dihapus');
    }
}