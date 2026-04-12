@extends('anggota.layouts.app')

@section('content')

<h3 class="fw-bold mb-4">Dashboard Anggota</h3>

{{-- ================= CARD STATISTIK ================= --}}
<div class="row g-3">

    {{-- Total Buku --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 d-flex flex-row justify-content-between align-items-center rounded-4 hover-card" style="background:#e7f1ff;">
            <div>
                <small class="text-muted">Total Buku</small>
                <h4 class="fw-bold text-primary mb-0">{{ $totalBuku }}</h4>
            </div>
            <i class="bi bi-book fs-1 text-primary"></i>
        </div>
    </div>

    {{-- Buku Dipinjam --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 d-flex flex-row justify-content-between align-items-center rounded-4 hover-card" style="background:#fff3cd;">
            <div>
                <small class="text-muted">Buku Dipinjam</small>
                <h4 class="fw-bold text-warning mb-0">{{ $bukuDipinjam }}</h4>
            </div>
            <i class="bi bi-journal-check fs-1 text-warning"></i>
        </div>
    </div>

    {{-- Notifikasi --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 d-flex flex-row justify-content-between align-items-center rounded-4 hover-card" style="background:#e8f8f0;">
            <div>
                <small class="text-muted">Notifikasi</small>
                <h4 class="fw-bold text-success mb-0">{{ $jumlahNotifikasi }}</h4>
            </div>
            <i class="bi bi-bell fs-1 text-success"></i>
        </div>
    </div>

</div>

{{-- ================= WELCOME ================= --}}
<div class="card mt-4 border-0 shadow-sm rounded-4">
    <div class="card-body">
        <h5 class="fw-bold mb-1">Selamat Datang, {{ auth()->user()->name }} 👋</h5>
        <p class="mb-3 text-muted">
            Kamu bisa pinjam buku, lihat riwayat, dan pantau status pengembalian di sini.
        </p>

        {{-- QUICK ACTION --}}
        <a href="{{ route('anggota.buku.index') }}" class="btn btn-primary rounded-pill btn-sm">
            📚 Lihat Buku
        </a>

        <a href="{{ route('anggota.riwayat') }}" class="btn btn-success rounded-pill btn-sm">
            📜 Riwayat
        </a>
    </div>
</div>

{{-- ================= BUKU TERBARU ================= --}}
<div class="mt-4">
    <h5 class="fw-semibold mb-3">Buku Terbaru</h5>

    <div class="row g-3">
        @forelse($bukuTerbaru as $buku)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3 h-100 rounded-4 hover-card">

                    {{-- Cover --}}
                    @if($buku->cover)
                        <img src="{{ asset('storage/'.$buku->cover) }}" 
                             class="img-fluid mb-2 rounded" 
                             style="height:150px; object-fit:cover;">
                    @endif

                    <h6 class="fw-bold mb-1">{{ $buku->judul }}</h6>
                    <small class="text-muted d-block">{{ $buku->pengarang }}</small>

                    <a href="{{ route('anggota.katalog') }}" 
                       class="btn btn-outline-primary btn-sm mt-2 rounded-pill">
                        Lihat Detail
                    </a>
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

{{-- ================= RIWAYAT SINGKAT ================= --}}
<div class="card mt-4 border-0 shadow-sm rounded-4">
    <div class="card-header bg-white fw-bold">
        Aktivitas Terakhir
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Buku</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat ?? [] as $item)
                    <tr>
                        <td>{{ $item->buku->judul_buku ?? '-' }}</td>
                        <td>
                            <span class="badge bg-success">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            Belum ada aktivitas
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ================= STYLE TAMBAHAN ================= --}}
<style>
.hover-card {
    transition: 0.2s;
}
.hover-card:hover {
    transform: translateY(-5px);
}
</style>

@endsection