@extends('anggota.layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Katalog Buku</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        @foreach($bukuList as $buku)
        <div class="col-md-4 col-sm-6 col-12 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('storage/'.$buku->cover) }}" class="card-img-top" alt="Cover Buku">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $buku->judul }}</h5>
                    <p class="card-text">Penulis: {{ $buku->penulis }}</p>
                    <p class="card-text">Stok: {{ $buku->stok }}</p>
                    <div class="mt-auto d-flex gap-2">
                        <a href="{{ route('anggota.buku.view', $buku->id) }}" class="btn btn-primary w-50">Detail</a>
                        @if($buku->stok > 0)
                            <form action="{{ route('anggota.buku.pinjam.store', $buku->id) }}" method="POST" class="w-50">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">Pinjam</button>
                            </form>
                        @else
                            <button class="btn btn-secondary w-50" disabled>Stok Habis</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection