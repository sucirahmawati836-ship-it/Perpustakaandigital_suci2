@extends('anggota.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <h3 class="mb-4">Detail Buku</h3>

            <div class="card shadow-sm p-4">
                <img src="{{ asset('storage/'.$buku->cover) }}"
                class="img-fluid mb-3"style="height:250px; object-fit:cover;" alt="Cover Buku">
                <table class="table table-borderless">
                    <tr>
                        <th>Kode Buku</th>
                        <td>{{ $buku->kode_buku ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Judul Buku</th>
                        <td>{{ $buku->judul_buku }}</td>
                    </tr>
                    <tr>
                        <th>Penulis</th>
                        <td>{{ $buku->penulis }}</td>
                    </tr>
                    <tr>
                        <th>Tahun Terbit</th>
                        <td>{{ $buku->tahun_terbit ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Stok</th>
                        <td>{{ $buku->stok }}</td>
                    </tr>
                    <tr>
                        <th>Sinopsis</th>
                        <td style="max-height:100px; overflow:auto;">
                         {{ $buku->sinopsis ?? '-' }}
                        </td>
                    </tr>
                </table>

                @if($buku->stok > 0)
                    <form action="{{ route('anggota.buku.pinjam.store', $buku->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-success w-100 mb-2">Pinjam Buku</button>
                    </form>
                @else
                    <button class="btn btn-secondary w-100 mb-2" disabled>Stok Habis</button>
                @endif

                <a href="{{ route('anggota.buku.index') }}" class="btn btn-primary w-100">
                    Kembali 
                </a>
            </div>

        </div>
    </div>
</div>
@endsection