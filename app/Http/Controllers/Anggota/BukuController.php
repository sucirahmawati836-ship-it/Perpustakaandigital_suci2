<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    // ================= KATALOG INDEX =================
    public function index()
    {
        $bukuList = Buku::all(); // semua buku
        return view('anggota.buku.index', compact('bukuList'));
    }

    // ================= VIEW DETAIL BUKU =================
    public function view(Buku $buku)
    {
        return view('anggota.buku.view', compact('buku'));
    }
}