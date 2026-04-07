@extends('petugas.layouts.app')

@section('content')
<div class="container" style="max-width: 700px; margin-top:50px;">
    <div class="card shadow-sm p-4">
        <h3 class="mb-3 text-center">Edit Buku - {{ $buku->judul_buku }}</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('petugas.buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="kode_buku" class="form-label">Kode Buku</label>
                <input type="text" name="kode_buku" id="kode_buku" class="form-control" value="{{ old('kode_buku', $buku->kode_buku) }}" required>
            </div>

            <div class="mb-3">
                <label for="judul_buku" class="form-label">Judul Buku</label>
                <input type="text" name="judul_buku" id="judul_buku" class="form-control" value="{{ old('judul_buku', $buku->judul_buku) }}" required>
            </div>

            <div class="mb-3">
                <label for="penulis" class="form-label">Penulis</label>
                <input type="text" name="penulis" id="penulis" class="form-control" value="{{ old('penulis', $buku->penulis) }}" required>
            </div>

            <div class="mb-3">
                <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" id="tahun_terbit" class="form-control" value="{{ old('tahun_terbit', date('Y', strtotime($buku->tahun_terbit))) }}" required>
            </div>

            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" name="stok" id="stok" class="form-control" value="{{ old('stok', $buku->stok) }}" required>
            </div>

            <div class="mb-3">
                <label for="sinopsis" class="form-label">Sinopsis</label>
                <textarea name="sinopsis" id="sinopsis" class="form-control" rows="4">{{ old('sinopsis', $buku->sinopsis) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="cover" class="form-label">Cover (opsional)</label>
                <input type="file" name="cover" id="cover" class="form-control">
                @if($buku->cover)
                    <img src="{{ asset('storage/'.$buku->cover) }}" alt="Cover Lama" class="img-fluid mt-2" style="max-height:200px;">
                @endif
            </div>

            <button type="submit" class="btn btn-success w-100 mb-2">Update Buku</button>
            <a href="{{ route('petugas.buku.index') }}" class="btn btn-secondary w-100">Batal</a>
        </form>
    </div>
</div>
@endsection