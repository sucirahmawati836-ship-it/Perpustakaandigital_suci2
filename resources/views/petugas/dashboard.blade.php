@extends('petugas.layouts.app')

@section('content')
<div class="container-fluid">

    <h3 class="mb-4 fw-bold">Dashboard Petugas</h3>

    <div class="row">
        
        <!-- TOTAL PEMINJAMAN -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm" style="background:#e7f1ff;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted">Peminjaman</h6>
                        <h1 class="fw-bold text-primary">{{ $peminjaman }}</h1>
                    </div>
                    <div style="font-size:40px;">📄</div>
                </div>
            </div>
        </div>

        <!-- TOTAL PENGEMBALIAN -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm" style="background:#e8f8f0;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted">Sedang Dipinjam</h6>
                        <h1 class="fw-bold text-success">{{ $pinjamanAktif }}</h1>
                    </div>
                    <div style="font-size:40px;">📦</div>
                </div>
            </div>
        </div>

        <!-- TOTAL BUKU -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm" style="background:#fff8e1;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted">Total Buku</h6>
                        <h1 class="fw-bold text-warning">{{ $totalBuku }}</h1>
                    </div>
                    <div style="font-size:40px;">📚</div>
                </div>
            </div>
        </div>

    </div>

    <!-- SELAMAT DATANG -->
    <div class="card shadow-sm mt-3 border-0">
        <div class="card-body">
            <h5 class="fw-bold">
                Selamat Datang, {{ auth()->user()->name ?? 'User' }} 👋
            </h5>
            <p class="mb-0 text-muted">
                Anda dapat mengelola pengajuan peminjaman, proses pengembalian buku, 
                serta memantau aktivitas perpustakaan melalui menu di samping.
            </p>
        </div>
    </div>

</div>
@endsection