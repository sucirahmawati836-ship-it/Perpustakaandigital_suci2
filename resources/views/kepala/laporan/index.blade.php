@extends('kepala.layouts.app')

@section('content')
<div class="container-fluid">

    <h3 class="mb-4 fw-bold">Laporan Sirkulasi Buku</h3>

    <!-- FILTER -->
    <form method="GET" class="row mb-3">
        <div class="col-md-3">
            <input type="date" name="dari" class="form-control" value="{{ request('dari') }}">
        </div>
        <div class="col-md-3">
            <input type="date" name="sampai" class="form-control" value="{{ request('sampai') }}">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary">Filter</button>
        </div>
    </form>

    <!-- CETAK -->
    <button onclick="window.print()" class="btn btn-success mb-3">
        🖨️ Cetak Laporan
    </button>

    <div id="area-cetak">

        <!-- KOP -->
        <div class="text-center mb-4">
            <h4 class="fw-bold">PERPUSTAKAAN SEKOLAH</h4>
            <p>Laporan Sirkulasi Buku</p>
            <small>Tanggal Cetak: {{ date('d-m-Y') }}</small>
        </div>

        <!-- ================= REKAP ================= -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                Rekap Peminjaman & Pengembalian
            </div>
            <div class="card-body">

                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>No</th>
                            <th>Judul Buku</th>
                            <th>Nama</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                            <th>Kondisi Buku</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php $no = 1; @endphp

                        {{-- PEMINJAMAN --}}
                        @forelse($peminjaman as $p)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td>{{ $p->buku->judul_buku }}</td>
                            <td>{{ $p->user->name }}</td>
                            <td class="text-center">{{ $p->tanggal_pinjam ?? '-' }}</td>
                            <td class="text-center">-</td>
                            <td class="text-center">{{ $p->tanggal_jatuh_tempo ?? '-' }}</td>
                            <td class="text-center">
                                <span class="badge bg-warning text-dark">Dipinjam</span>
                            </td>
                            <td class="text-center">-</td>
                        </tr>
                        @empty
                        @endforelse

                        {{-- PENGEMBALIAN --}}
                        @forelse($pengembalian as $p)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td>{{ $p->buku->judul_buku }}</td>
                            <td>{{ $p->user->name }}</td>
                            <td class="text-center">{{ $p->tanggal_pinjam ?? '-' }}</td>
                            <td class="text-center">{{ $p->tanggal_kembali ?? '-' }}</td>
                            <td class="text-center">{{ $p->tanggal_jatuh_tempo ?? '-' }}</td>

                            <td class="text-center">
                                @if($p->tanggal_kembali && $p->tanggal_jatuh_tempo)
                                    @if($p->tanggal_kembali > $p->tanggal_jatuh_tempo)
                                        <span class="badge bg-danger">Terlambat</span>
                                    @else
                                        <span class="badge bg-success">Tepat Waktu</span>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>

                            <td class="text-center">
                                {{ ucfirst($p->kondisi_buku ?? '-') }}
                            </td>
                        </tr>
                        @empty
                        @endforelse

                        {{-- JIKA KOSONG --}}
                        @if($peminjaman->isEmpty() && $pengembalian->isEmpty())
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                Tidak ada data
                            </td>
                        </tr>
                        @endif

                    </tbody>
                </table>

            </div>
        </div>

        <!-- ================= DENDA ================= -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-danger text-white">Rekap Pembayaran Denda</div>
            <div class="card-body">

                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>No</th>
                            <th>Judul Buku</th>
                            <th>Nama</th>
                            <th>Kondisi</th>
                            <th>Denda</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Penerima</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($denda as $i => $p)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td>{{ $p->buku->judul_buku }}</td>
                            <td>{{ $p->user->name }}</td>

                            <td class="text-center">
                                {{ ucfirst($p->kondisi_buku ?? '-') }}
                            </td>

                            <td class="text-end">
                                @if(($p->denda ?? 0) > 0)
                                    <span class="text-danger fw-bold">
                                        Rp {{ number_format($p->denda, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-success">Rp 0</span>
                                @endif
                            </td>

                            <td class="text-center">
                                @if($p->metode_pembayaran == 'transfer')
                                    Transfer
                                @elseif($p->metode_pembayaran == 'cash')
                                    Tunai
                                @else
                                    -
                                @endif
                            </td>

                            <td class="text-center">
                                @if($p->status_denda == 'lunas')
                                    <span class="text-success">Lunas</span>
                                @else
                                    <span class="text-danger">Belum</span>
                                @endif
                            </td>

                            <td>{{ $p->penerima ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                Tidak ada data
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- TOTAL -->
                <div class="mt-3 text-end">
                    <strong>
                        Total Denda: 
                        Rp {{ number_format($denda->sum('denda'), 0, ',', '.') }}
                    </strong>
                </div>

            </div>
        </div>

    </div>
</div>

<!-- PRINT STYLE -->
<style>
@media print {

    body * {
        visibility: hidden;
    }

    #area-cetak, #area-cetak * {
        visibility: visible;
    }

    #area-cetak {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }

    button, form {
        display: none;
    }
}
</style>

@endsection