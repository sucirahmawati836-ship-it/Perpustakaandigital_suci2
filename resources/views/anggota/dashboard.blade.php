@extends('anggota.layouts.app')

@section('content')

{{-- ================= HEADER ================= --}}
<h3 class="fw-bold mb-4">Dashboard Anggota</h3>

<div class="row g-3">

    {{-- Total Buku --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 d-flex flex-row justify-content-between align-items-center" style="background:#e7f1ff;">
            <div>
                <small class="text-muted">Total Buku</small>
                <h5 class="fw-bold text-primary mb-0">{{ $totalBuku }}</h5>
            </div>
            <i class="bi bi-book fs-2 text-primary"></i>
        </div>
    </div>

    {{-- Buku Dipinjam --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 d-flex flex-row justify-content-between align-items-center" style="background:#fff3cd;">
            <div>
                <small class="text-muted">Buku Dipinjam</small>
                <h5 class="fw-bold text-warning mb-0">{{ $bukuDipinjam }}</h5>
            </div>
            <i class="bi bi-check-circle fs-2 text-warning"></i>
        </div>
    </div>

    {{-- Notifikasi --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 d-flex flex-row justify-content-between align-items-center" style="background:#e8f8f0;">
            <div>
                <small class="text-muted">Notifikasi</small>
                <h5 class="fw-bold text-success mb-0">{{ $jumlahNotifikasi }}</h5>
            </div>
            <i class="bi bi-bell fs-2 text-success"></i>
        </div>
    </div>

</div>

{{-- ================= SELAMAT DATANG ================= --}}
<div class="card mt-4 border-0 shadow-sm">
    <div class="card-body">
        <h5 class="fw-bold">Selamat Datang, {{ auth()->user()->name }} 👋</h5>
        <p class="mb-0 text-muted">
            Selamat datang di sistem E-Perpus. Kamu dapat melihat daftar buku, melakukan peminjaman,
            serta memantau riwayat peminjaman dengan mudah melalui menu di samping.
        </p>
    </div>
</div>

{{-- ================= BUKU TERBARU ================= --}}
<div class="mt-4">
    <h5 class="fw-semibold mb-3">Buku Terbaru</h5>

    <div class="row g-3">
        @forelse($bukuTerbaru as $buku)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3 h-100">
                    <h6 class="fw-bold mb-1">{{ $buku->judul }}</h6>
                    <small class="text-muted">{{ $buku->pengarang }}</small>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-secondary text-center">
                    Belum ada data buku terbaru
                </div>
            </div>
        @endforelse
    </div>
</div>

@endsection