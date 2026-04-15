@extends('petugas.layouts.app')

@section('content')

<div class="container mt-4">
    <h3 class="mb-4">Data Pengembalian</h3>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm p-3">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Judul Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Tempo</th>
                    <th>Tgl Pengembalian</th>
                    <th>Status</th>
                    <th>Denda</th>
                    <th>Kondisi</th>
                    <th>Status Denda</th>
                    <th>Metode</th>
                    <th>Aksi</th>
                    <th>Struk</th>
                </tr>
            </thead>

            <tbody>
                @forelse($pengembalianList as $i => $p)
                <tr>

                    <td>{{ $i + 1 }}</td>
                    <td>{{ $p->user->name }}</td>
                    <td class="text-start">{{ $p->buku->judul_buku }}</td>

                    <td>
                        {{ $p->tanggal_pinjam ? \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') : '-' }}
                    </td>

                    <td>
                        {{ $p->tanggal_jatuh_tempo ? \Carbon\Carbon::parse($p->tanggal_jatuh_tempo)->format('d M Y') : '-' }}
                    </td>

                    {{-- TANGGAL PENGEMBALIAN --}}
                    <td>
                        {{ $p->tanggal_kembali 
                            ? \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M Y H:i') 
                            : '-' }}
                    </td>

                    {{-- STATUS --}}
                    <td>
                        @if($p->status == 'dikembalikan')
                            <span class="badge bg-success">Dikembalikan</span>
                        @else
                            <span class="badge bg-warning">Dipinjam</span>
                        @endif
                    </td>

                    {{-- DENDA --}}
                    <td>
                        @php
                            $denda = $p->denda ?? 0;
                        @endphp

                        @if($denda > 0)
                            <span class="text-danger fw-bold">
                                Rp {{ number_format($denda, 0, ',', '.') }}
                            </span>
                        @else
                            Rp 0
                        @endif
                    </td>

                    {{-- KONDISI --}}
                    <td>
                        @if($p->kondisi_buku == 'baik')
                            <span class="badge bg-success">Baik</span>
                        @elseif($p->kondisi_buku == 'rusak')
                            <span class="badge bg-warning">Rusak</span>
                        @elseif($p->kondisi_buku == 'hilang')
                            <span class="badge bg-danger">Hilang</span>
                        @else
                            -
                        @endif
                    </td>

                    {{-- STATUS DENDA --}}
                    <td>
                        @if(($p->denda ?? 0) == 0)
                            -
                        @elseif($p->status_denda == 'lunas')
                            <span class="badge bg-success">Lunas</span>
                        @elseif($p->status_denda == 'menunggu_verifikasi')
                            <span class="badge bg-warning">Menunggu</span>
                        @else
                            <span class="badge bg-danger">Belum Bayar</span>
                        @endif
                    </td>

                    {{-- METODE --}}
                    <td>
                        {{ $p->metode_pembayaran ?? '-' }}
                    </td>

                    {{-- AKSI --}}
                    <td>

                        @if($p->status != 'dikembalikan')
                            <button class="btn btn-primary btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modal{{ $p->id }}">
                                Kembalikan
                            </button>
                        @else
                            <span class="badge bg-success">Selesai</span>
                        @endif

                        @if($p->status_denda == 'menunggu_verifikasi')
                            <form action="{{ route('petugas.verifikasi', $p->id) }}"
                                method="POST"
                                class="mt-1">
                                @csrf
                                <button class="btn btn-success btn-sm w-100">
                                    Verifikasi Pembayaran
                                </button>
                            </form>
                        @endif

                    </td>

                    {{-- STRUK --}}
                    <td>
                        @if($p->status_denda == 'lunas')
                            <a href="{{ route('petugas.struk', $p->id) }}"
                               target="_blank"
                               class="btn btn-secondary btn-sm">
                                Cetak
                            </a>
                        @else
                            -
                        @endif
                    </td>

                </tr>

                {{-- MODAL --}}
                <div class="modal fade" id="modal{{ $p->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Kondisi Buku</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body text-center">

                                <form action="{{ route('petugas.pengembalian.kembalikan', $p->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')

                                    <button name="jenis_denda" value="baik"
                                        class="btn btn-success m-1">
                                        Baik
                                    </button>

                                    <button name="jenis_denda" value="rusak"
                                        class="btn btn-warning m-1">
                                        Rusak
                                    </button>

                                    <button name="jenis_denda" value="hilang"
                                        class="btn btn-danger m-1">
                                        Hilang
                                    </button>

                                </form>

                            </div>

                        </div>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="13">Tidak ada data</td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>

@endsection