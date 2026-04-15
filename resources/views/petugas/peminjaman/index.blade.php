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
                        @elseif($p->status == 'ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                        @else
                            <span class="badge bg-secondary">{{ $p->status }}</span>
                        @endif
                    </td>

                    {{-- AKSI --}}
                    <td>
                        @if($p->status == 'menunggu')
                            
                            {{-- ACC --}}
                            <form action="{{ route('petugas.peminjaman.terima', $p->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-success btn-sm">
                                    Terima
                                </button>
                            </form>

                            {{-- TOLAK (PAKAI MODAL) --}}
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#tolakModal{{ $p->id }}">
                                Tolak
                            </button>

                            {{-- MODAL --}}
                            <div class="modal fade" id="tolakModal{{ $p->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <form action="{{ route('petugas.peminjaman.tolak', $p->id) }}" method="POST">
                                            @csrf

                                            <div class="modal-header">
                                                <h5 class="modal-title">Alasan Penolakan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                <label class="form-label">Masukkan alasan:</label>

                                                {{-- pilihan cepat --}}
                                                <div class="mb-2">
                                                    <button type="button" class="btn btn-warning btn-sm" onclick="isiAlasan('Stok buku habis', {{ $p->id }})">Stok habis</button>
                                                    <button type="button" class="btn btn-info btn-sm" onclick="isiAlasan('Data tidak valid', {{ $p->id }})">Data tidak valid</button>
                                                </div>

                                                <textarea name="alasan" id="alasan{{ $p->id }}" class="form-control" required></textarea>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger">Kirim</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>

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

{{-- SCRIPT ISI OTOMATIS --}}
<script>
function isiAlasan(text, id){
    document.getElementById('alasan'+id).value = text;
}
</script>

@endsection