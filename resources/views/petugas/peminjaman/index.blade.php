@extends('petugas.layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Data Peminjaman</h3>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tabel --}}
    <div class="card shadow-sm p-3">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($peminjamanList as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $p->user->name }}</td>
                    <td>{{ $p->buku->judul_buku }}</td>
                    <td>{{ $p->tanggal_pinjam ?? '-' }}</td>

                    {{-- STATUS --}}
                    <td>
                        @if($p->status == 'menunggu')
                            <span class="badge bg-warning text-dark">Menunggu</span>
                        @elseif($p->status == 'dipinjam')
                            <span class="badge bg-success">Dipinjam</span>
                        @else
                            <span class="badge bg-secondary">{{ $p->status }}</span>
                        @endif
                    </td>

                    {{-- AKSI --}}
                    <td>
                        @if($p->status == 'menunggu')
                            <form action="{{ route('petugas.peminjaman.acc', $p->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-success btn-sm">
                                    ACC
                                </button>
                            </form>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data peminjaman</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection