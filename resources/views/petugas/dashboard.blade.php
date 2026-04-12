@extends('petugas.layouts.app')

@section('content')
<div class="container-fluid">

    <h3 class="mb-4 fw-bold">Dashboard Petugas</h3>

    <div class="row">

        <!-- PEMINJAMAN -->
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm p-3 hover-card" style="background:#e7f1ff;">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted">Menunggu</h6>
                        <h3 class="fw-bold text-primary">{{ $peminjaman }}</h3>
                    </div>
                    <div class="fs-1">📄</div>
                </div>
            </div>
        </div>

        <!-- DIPINJAM -->
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm p-3 hover-card" style="background:#e8f8f0;">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted">Dipinjam</h6>
                        <h3 class="fw-bold text-success">{{ $pinjamanAktif }}</h3>
                    </div>
                    <div class="fs-1">📦</div>
                </div>
            </div>
        </div>

        <!-- TOTAL BUKU -->
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm p-3 hover-card" style="background:#fff8e1;">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted">Total Buku</h6>
                        <h3 class="fw-bold text-warning">{{ $totalBuku }}</h3>
                    </div>
                    <div class="fs-1">📚</div>
                </div>
            </div>
        </div>

        <!-- PENGEMBALIAN HARI INI -->
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm p-3 hover-card" style="background:#e0f7fa;">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted">Dikembalikan Hari Ini</h6>
                        <h3 class="fw-bold text-info">{{ $pengembalianHariIni ?? 0 }}</h3>
                    </div>
                    <div class="fs-1">🔁</div>
                </div>
            </div>
        </div>

    </div>

    <!-- WELCOME -->
    <div class="card shadow-sm mt-3 border-0">
        <div class="card-body">
            <h5 class="fw-bold">
                Selamat Datang, {{ auth()->user()->name ?? 'User' }} 👋
            </h5>
            <p class="mb-2 text-muted">
                Kelola peminjaman, pengembalian, dan buku dengan mudah.
            </p>

            <!-- QUICK ACTION -->
            <a href="{{ route('petugas.peminjaman.index') }}" class="btn btn-warning btn-sm rounded-pill">
                📥 Peminjaman
            </a>

            <a href="{{ route('petugas.pengembalian.index') }}" class="btn btn-success btn-sm rounded-pill">
                🔁 Pengembalian
            </a>

            <a href="{{ route('petugas.daftar_buku') }}" class="btn btn-primary btn-sm rounded-pill">
                📚 Buku
            </a>
        </div>
    </div>

    <!-- AKTIVITAS TERBARU -->
    <div class="card shadow-sm mt-4 border-0">
        <div class="card-header bg-white fw-bold">
            Aktivitas Terbaru
        </div>

        <div class="card-body">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Buku</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($aktivitas as $item)
                        <tr>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->buku->judul_buku }}</td>
                            <td>
                                <span class="badge bg-success">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td>{{ $item->created_at->format('d-m-Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                Belum ada aktivitas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<style>
.hover-card {
    transition: 0.2s;
}
.hover-card:hover {
    transform: translateY(-5px);
}
</style>

@endsection