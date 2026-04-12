@extends('anggota.layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Riwayat Peminjaman</h3>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Jatuh Tempo</th> <!-- Tambah -->
                <th>Tanggal Kembali</th> <!-- Tambah -->
                <th>Status</th>
                <th>Denda</th>
                <th>Status Denda</th>
                <th>Metode Pembayaran</th>
                <th>Tanggal Bayar</th> 
                <th>Keterangan</th>
            </tr>
        </thead>

        <tbody>
        @forelse($peminjamanList as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->buku->judul_buku }}</td>
                
                {{-- Tanggal Pinjam --}}
                <td>{{ $p->tanggal_pinjam ?? '-' }}</td>

                {{-- Tanggal Jatuh Tempo --}}
                <td>
                    @if($p->status != 'ditolak')
                        {{ $p->tanggal_jatuh_tempo 
                            ? \Carbon\Carbon::parse($p->tanggal_jatuh_tempo)->format('d M Y') 
                            : \Carbon\Carbon::parse($p->tanggal_pinjam)->addDays(3)->format('d M Y') }}
                    @else
                        -
                    @endif
                </td>

                {{-- Tanggal Kembali --}}
                <td>
                    @if($p->status != 'ditolak')
                        {{ $p->tanggal_kembali 
                            ? \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M Y') 
                            : '-' }}
                    @else
                        -
                    @endif
                </td>

                {{-- STATUS --}}
                <td>
                    @if($p->status == 'menunggu')
                        <span class="badge bg-warning">Menunggu</span>

                    @elseif($p->status == 'dipinjam')
                        <span class="badge bg-success">Dipinjam</span>

                        @php
                            $jatuhTempo = $p->tanggal_jatuh_tempo 
                                ? \Carbon\Carbon::parse($p->tanggal_jatuh_tempo)
                                : \Carbon\Carbon::parse($p->tanggal_pinjam)->addDays(3);
                        @endphp

                        @if(now()->greaterThan($jatuhTempo))
                            <br>
                            <span class="badge bg-danger">Terlambat</span>
                        @endif

                    @elseif($p->status == 'dikembalikan')
                        <span class="badge bg-primary">Dikembalikan</span>

                    @elseif($p->status == 'ditolak')
                        <span class="badge bg-danger">Ditolak</span>
                    @endif
                </td>

                {{-- DENDA --}}
                <td>
                    @if($p->denda > 0)
                        Rp {{ number_format($p->denda, 0, ',', '.') }}
                    @else
                        Rp 0
                    @endif
                </td>

                {{-- STATUS DENDA --}}
                <td>
                    @if($p->status == 'dikembalikan')
                        @if($p->denda > 0)
                            @if($p->status_denda == 'lunas')
                                <span class="badge bg-success">Lunas</span>
                            @else
                                <span class="badge bg-danger">Belum Bayar</span>
                            @endif
                        @else
                            -
                        @endif
                    @else
                        -
                    @endif
                </td>

                {{-- METODE PEMBAYARAN --}}
                <td>
                    @if($p->status_denda == 'belum_bayar' && $p->denda > 0)
                        <form action="{{ route('anggota.bayar', $p->id) }}" method="POST">
                        @csrf
                        <select name="metode_pembayaran" class="form-select form-select-sm mb-1" required>
                           <option value="">Pilih Metode</option>
                           <option value="transfer">Transfer</option>
                           <option value="cash">Cash</option>
                        </select>
                        <button class="btn btn-primary btn-sm w-30">Bayar</button>
                        </form>
                    @elseif($p->status_denda == 'menunggu_verifikasi')
                        <span class="badge bg-warning">Menunggu Verifikasi</span>
                    @elseif($p->status_denda == 'lunas')
                        <span class="badge bg-success">{{ ucfirst($p->metode_pembayaran) }}</span>
                    @else
                        -
                    @endif
                </td>

                {{-- TANGGAL BAYAR --}}
                <td>
                    {{ $p->tanggal_bayar 
                        ? \Carbon\Carbon::parse($p->tanggal_bayar)->format('d M Y') 
                        : '-' }}
                </td>

                {{-- KETERANGAN --}}
                <td>
                    @if($p->status == 'ditolak')
                        <span class="text-danger">
                            Ditolak oleh petugas
                            <br>
                            {{ $p->alasan_penolakan ?? '-' }}
                        </span>
                    @elseif($p->status == 'dikembalikan' && $p->denda > 0)
                        <span class="text-warning">Ada denda keterlambatan</span>
                    @else
                        -
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="11" class="text-center">Tidak ada data</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection