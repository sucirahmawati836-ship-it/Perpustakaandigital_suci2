@extends('layouts.app')

@section('content')

<div class="container">

    <h3 class="mb-3">Edit Buku</h3>

    <a href="{{ route('kepala.buku.index') }}" class="btn btn-secondary mb-3">
        ← Kembali
    </a>

    <div class="card shadow-sm">
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('kepala.buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Kode Buku</label>
                    <input type="text" name="kode_buku" class="form-control"
                           value="{{ old('kode_buku', $buku->kode_buku) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul Buku</label>
                    <input type="text" name="judul_buku" class="form-control"
                           value="{{ old('judul_buku', $buku->judul_buku) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Penulis</label>
                    <input type="text" name="penulis" class="form-control"
                           value="{{ old('penulis', $buku->penulis) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" class="form-control"
                           value="{{ old('tahun_terbit', $buku->tahun_terbit) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control"
                           value="{{ old('stok', $buku->stok) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Sinopsis</label>
                    <textarea name="sinopsis" class="form-control" rows="3">{{ old('sinopsis', $buku->sinopsis) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cover Lama</label><br>
                    @if($buku->cover)
                        <img src="{{ asset('storage/' . $buku->cover) }}" width="100" class="mb-2">
                    @else
                        <p class="text-muted">Tidak ada cover</p>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Ganti Cover</label>
                    <input type="file" name="cover" class="form-control">
                </div>

                <button type="submit" class="btn btn-success">
                    Update
                </button>

            </form>

        </div>
    </div>

</div>

@endsection