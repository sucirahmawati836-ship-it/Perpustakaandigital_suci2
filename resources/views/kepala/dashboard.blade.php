@extends('kepala.layouts.app')

@section('content')

<div class="container-fluid">

    <h3 class="mb-4 fw-bold">Dashboard Kepala Perpustakaan</h3>

    {{-- ================= STATISTIK UTAMA ================= --}}
    <div class="row g-3">

        {{-- TOTAL AKUN --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 hover-card" style="background:#e7f1ff;">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted">Total Akun</h6>
                        <h3 class="fw-bold text-primary">{{ $totalAkun }}</h3>
                    </div>
                    <div class="fs-1">👥</div>
                </div>
            </div>
        </div>

        {{-- TOTAL BUKU --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 hover-card" style="background:#e8f8f0;">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted">Total Buku</h6>
                        <h3 class="fw-bold text-success">{{ $totalBuku }}</h3>
                    </div>
                    <div class="fs-1">📚</div>
                </div>
            </div>
        </div>

        {{-- TOTAL PEMINJAMAN --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 hover-card" style="background:#fff8e1;">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted">Total Peminjaman</h6>
                        <h3 class="fw-bold text-warning">{{ $totalPeminjaman }}</h3>
                    </div>
                    <div class="fs-1">🧑‍🎓</div>
                </div>
            </div>
        </div>

    </div>

    {{-- ================= STATISTIK TAMBAHAN ================= --}}
    <div class="row mt-2 g-3">

        {{-- DIPINJAM --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 hover-card" style="background:#e0f7fa;">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted">Dipinjam</h6>
                        <h3 class="fw-bold text-info">{{ $dipinjam }}</h3>
                    </div>
                    <div class="fs-1">📦</div>
                </div>
            </div>
        </div>

        {{-- DIKEMBALIKAN --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 hover-card" style="background:#fce4ec;">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted">Dikembalikan</h6>
                        <h3 class="fw-bold text-danger">{{ $dikembalikan }}</h3>
                    </div>
                    <div class="fs-1">🔁</div>
                </div>
            </div>
        </div>

        {{-- TOTAL DENDA --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 hover-card" style="background:#fff3cd;">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted">Total Denda</h6>
                        <h3 class="fw-bold text-warning">
                            Rp {{ number_format($totalDenda) }}
                        </h3>
                    </div>
                    <div class="fs-1">💰</div>
                </div>
            </div>
        </div>

    </div>

    {{-- ================= WELCOME ================= --}}
    <div class="card shadow-sm mt-3 border-0">
        <div class="card-body">
            <h5 class="fw-bold">
                Selamat Datang, {{ auth()->user()->name }} 👋
            </h5>
            <p class="mb-0 text-muted">
                Anda dapat memantau seluruh aktivitas perpustakaan, termasuk peminjaman, pengembalian, dan laporan denda.
            </p>
        </div>
    </div>

    {{-- ================= AKTIVITAS TERBARU ================= --}}
    <div class="card mt-4 border-0 shadow-sm">
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
                    @forelse($peminjamanTerbaru as $item)
                        <tr>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->buku->judul }}</td>
                            <td>
                                <span class="badge 
                                    @if($item->status == 'dipinjam') bg-success
                                    @elseif($item->status == 'dikembalikan') bg-primary
                                    @elseif($item->status == 'ditolak') bg-danger
                                    @else bg-secondary
                                    @endif
                                ">
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

{{-- ================= STYLE ================= --}}
<style>
.hover-card {
    transition: 0.2s;
}
.hover-card:hover {
    transform: translateY(-5px);
}
</style>

@endsection