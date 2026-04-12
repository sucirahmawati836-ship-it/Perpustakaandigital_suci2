@extends('kepala.layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4 fw-bold">Laporan Sirkulasi Buku</h3>

    <div class="card mb-4">
    <div class="card-header bg-success text-white">
        Rekap Pengembalian Buku
    </div>
    <div class="card-body">

        @foreach($pengembalian as $p)
        <div class="border-bottom mb-3 pb-2">

            <strong>{{ $p->buku->judul_buku}}</strong><br>

            <small>Nama: {{ $p->user->name }}</small><br>

            <small>Tanggal Pinjam: 
                {{ $p->tanggal_pinjam ?? '-' }}
            </small><br>

            <small>Tanggal Kembali: 
                {{ $p->tanggal_kembali ?? '-' }}
            </small><br>

            <small>Denda: 
                Rp {{ number_format($p->denda ?? 0, 0, ',', '.') }}
            </small><br>

            <small>Status Bayar: 
                @if($p->status_denda == 'lunas')
                    <span class="text-success">Lunas</span>
                @else
                    <span class="text-danger">Belum Bayar</span>
                @endif
            </small>

        </div>
        @endforeach

      </div>
   </div>

  </div>
</div>
@endsection