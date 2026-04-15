@extends('anggota.layouts.app')

@section('content')

<div class="container mt-4">
    <h3>Riwayat Peminjaman</h3>

    <div class="card p-3 mt-3">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Pinjam</th>
                    <th>Tempo</th>
                    <th>Kembali</th>
                    <th>Status</th>
                    <th>Kondisi Buku</th> {{-- TAMBAHAN --}}
                    <th>Denda</th>
                    <th>Status Denda</th>
                    <th>Pembayaran</th>
                    <th>Tgl Bayar</th>
                </tr>
            </thead>

            <tbody>
            @forelse($peminjamanList as $i => $p)
                <tr>
                    <td>{{ $i+1 }}</td>

                    {{-- JUDUL BUKU --}}
                    <td>{{ $p->buku->judul_buku ?? '-' }}</td>

                    {{-- TANGGAL PINJAM --}}
                    <td>
                        {{ $p->tanggal_pinjam
                            ? \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y')
                            : '-' }}
                    </td>

                    {{-- TANGGAL TEMPO --}}
                    <td>
                        {{ $p->tanggal_jatuh_tempo
                            ? \Carbon\Carbon::parse($p->tanggal_jatuh_tempo)->format('d M Y')
                            : '-' }}
                    </td>

                    {{-- TANGGAL KEMBALI --}}
                    <td>
                        {{ $p->tanggal_kembali
                            ? \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M Y')
                            : '-' }}
                    </td>

                    {{-- STATUS --}}
                    <td>
                        @if($p->status == 'menunggu')
                            <span class="badge bg-warning">Menunggu</span>
                        @elseif($p->status == 'dipinjam')
                            <span class="badge bg-success">Dipinjam</span>
                        @elseif($p->status == 'dikembalikan')
                            <span class="badge bg-primary">Dikembalikan</span>
                        @elseif($p->status == 'ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </td>

                    {{-- KONDISI BUKU (FIX UTAMA) --}}
                    <td>
                        @if($p->kondisi_buku == 'baik')
                            <span class="badge bg-success">Baik</span>

                        @elseif($p->kondisi_buku == 'rusak')
                            <span class="badge bg-warning text-dark">Rusak</span>

                        @elseif($p->kondisi_buku == 'hilang')
                            <span class="badge bg-danger">Hilang</span>

                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>

                    {{-- DENDA --}}
                    <td>
                        @if(($p->denda ?? 0) > 0)
                            <span class="text-danger fw-bold">
                                Rp {{ number_format($p->denda,0,',','.') }}
                            </span>
                        @else
                            Rp 0
                        @endif
                    </td>

                    {{-- STATUS DENDA --}}
                    <td>
                        @if(($p->denda ?? 0) == 0)
                            -
                        @elseif($p->status_denda == 'lunas')
                            <span class="badge bg-success">Lunas</span>
                        @elseif($p->status_denda == 'menunggu_verifikasi')
                            <span class="badge bg-warning">Menunggu Verifikasi</span>
                        @else
                            <span class="badge bg-danger">Belum Bayar</span>
                        @endif
                    </td>

                    {{-- PEMBAYARAN --}}
                    <td>
                        @if(($p->denda ?? 0) == 0)
                            -
                        @elseif(in_array($p->status_denda, ['belum_bayar', null]))
                            <button class="btn btn-primary btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modalBayar{{ $p->id }}">
                                Bayar
                            </button>

                        @elseif($p->status_denda == 'menunggu_verifikasi')
                            <span class="badge bg-warning">Menunggu</span>

                        @elseif($p->status_denda == 'lunas')
                            <span class="badge bg-success">
                                {{ ucfirst($p->metode_pembayaran) }}
                            </span>
                        @endif
                    </td>

                    {{-- TANGGAL BAYAR --}}
                    <td>
                        {{ $p->tanggal_bayar
                            ? \Carbon\Carbon::parse($p->tanggal_bayar)->format('d M Y')
                            : '-' }}
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center">
                        Tidak ada data
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ================= MODAL BAYAR ================= --}}
@foreach($peminjamanList as $p)

<div class="modal fade" id="modalBayar{{ $p->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST" action="{{ route('anggota.bayar', $p->id) }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Bayar Denda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p><strong>{{ $p->buku->judul_buku ?? '-' }}</strong></p>

                    <p>
                        Denda:
                        <span class="text-danger fw-bold">
                            Rp {{ number_format($p->denda ?? 0,0,',','.') }}
                        </span>
                    </p>

                    <select name="metode_pembayaran" class="form-control" required>
                        <option value="">Pilih Metode</option>
                        <option value="transfer">Transfer</option>
                        <option value="cash">Cash</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        Bayar
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@endforeach

@endsection