@extends('petugas.layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Data Pengembalian</h3>

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
                    <th>Denda</th>
                    <th>Status Denda</th>
                    <th>Metode Bayar</th> {{-- TAMBAHAN --}}
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($pengembalianList as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $p->user->name }}</td>
                    <td>{{ $p->buku->judul_buku }}</td>
                    <td>{{ $p->tanggal_pinjam ?? '-' }}</td>

                    {{-- STATUS --}}
                    <td>
                        <span class="badge bg-success">Dipinjam</span>

                        @php
                            $batas = \Carbon\Carbon::parse($p->tanggal_jatuh_tempo ?? $p->tanggal_pinjam)->addDays(3);
                        @endphp

                        @if(now()->greaterThan($batas))
                            <span class="badge bg-danger">Terlambat</span>
                        @endif
                    </td>

                    {{-- DENDA --}}
                    <td>
                        @if($p->denda > 0)
                            <span class="text-danger fw-bold">
                                Rp {{ number_format($p->denda) }}
                            </span>
                        @else
                            <span class="text-success">Rp 0</span>
                        @endif
                    </td>

                    {{-- STATUS DENDA --}}
                    <td>
                        @if($p->status_denda == 'lunas')
                            <span class="badge bg-success">Lunas</span>

                        @elseif($p->status_denda == 'menunggu_verifikasi')
                            <span class="badge bg-warning">Menunggu Verifikasi</span>

                        @else
                            <span class="badge bg-danger">Belum Bayar</span>
                        @endif
                    </td>

                    {{-- METODE PEMBAYARAN (TAMBAHAN) --}}
                    <td>
                        @if($p->status_denda == 'menunggu_verifikasi')
                            <span class="badge bg-warning">
                                {{ ucfirst($p->metode_pembayaran) ?? '-' }}
                            </span>

                        @elseif($p->status_denda == 'lunas')
                            <span class="badge bg-success">
                                {{ ucfirst($p->metode_pembayaran) ?? '-' }}
                            </span>

                        @else
                            -
                        @endif
                    </td>

                    {{-- AKSI --}}
                    <td>
                        {{-- Tombol Kembalikan --}}
                        @if($p->status != 'dikembalikan')
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDenda{{ $p->id }}">
                                 Kembalikan
                            </button>
                        @else
                            <span class="badge bg-success">Selesai</span>
                        @endif

                        {{-- VERIFIKASI --}}
                        @if($p->status_denda == 'menunggu_verifikasi')
                          <form action="{{ route('petugas.verifikasi', $p->id) }}" method="POST" class="mt-1">
                            @csrf
                            <button class="btn btn-success btn-sm w-100">
                              Verifikasi Pembayaran
                            </button>
                         </form>
                        @endif
                    </td>
                </tr>

                {{-- MODAL PILIH DENDA --}}
                <div class="modal fade" id="modalDenda{{ $p->id }}" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content">

                      <div class="modal-header">
                        <h5 class="modal-title">Pilih Jenis Denda</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>

                      <div class="modal-body text-center">
                        <p>Pilih kondisi buku:</p>

                        <form action="{{ route('petugas.pengembalian.kembalikan', $p->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <button type="submit" name="jenis_denda" value="baik" class="btn btn-success m-1">
                                Baik
                            </button>

                            <button type="submit" name="jenis_denda" value="rusak" class="btn btn-warning m-1">
                                Rusak
                            </button>

                            <button type="submit" name="jenis_denda" value="hilang" class="btn btn-danger m-1">
                                Hilang
                            </button>
                        </form>
                      </div>

                    </div>
                  </div>
                </div>

                @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data pengembalian</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection