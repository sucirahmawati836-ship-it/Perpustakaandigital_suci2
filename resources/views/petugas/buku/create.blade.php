@extends('petugas.layouts.app')

@section('content')

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <h3 class="mb-3">Tambah Buku</h3>

            <a href="{{ route('petugas.buku.index') }}" class="btn btn-secondary mb-3">
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

                    <form action="{{ route('petugas.buku.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Kode Buku</label>
                            <input type="text" name="kode_buku" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Judul Buku</label>
                            <input type="text" name="judul_buku" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Penulis</label>
                            <input type="text" name="penulis" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tahun Terbit</label>
                            <input type="number" name="tahun_terbit" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sinopsis</label>
                            <textarea name="sinopsis" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Cover</label>
                            <input type="file" name="cover" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-success">
                            Simpan
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection