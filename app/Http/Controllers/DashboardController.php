<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Petugas;

class DashboardController extends Controller
{
    // tampilan dashboard
    public function index()
    {
        $totalAkun    = User::count();
        $totalBuku    = Buku::count();
        $totalAnggota = Anggota::count();
        $totalPetugas = Petugas::count();

        return view('kepala.dashboard', compact(
            'totalAkun',
            'totalBuku',
            'totalAnggota',
            'totalPetugas'
        ));
    }
}