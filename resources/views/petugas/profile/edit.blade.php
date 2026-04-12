@extends('petugas.layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">Edit Profile</h3>

    <div class="card p-4 shadow" style="max-width:500px; margin:auto;">

        <form action="{{ route('petugas.update', $petugas->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control"
                    value="{{ old('name', $petugas->user->name) }}">
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                    value="{{ old('email', $petugas->user->email) }}">
            </div>

            <div class="mb-3">
                <label>NIP</label>
                <input type="text" name="nip_petugas" class="form-control"
                    value="{{ old('nip_petugas', $petugas->nip_petugas) }}">
            </div>

            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('petugas.profile.index') }}" class="btn btn-secondary">Kembali</a>

        </form>

    </div>

</div>
@endsection