@extends('anggota.layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">Edit Profile</h3>

    <div class="card p-4 shadow" style="max-width:500px; margin:auto;">

        <form action="{{ route('anggota.update', $anggota->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control"
                    value="{{ old('name', $anggota->user->name) }}">
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                    value="{{ old('email', $anggota->user->email) }}">
            </div>

            <div class="mb-3">
                <label>NIS</label>
                <input type="text" name="nis" class="form-control"
                    value="{{ old('nis', $anggota->nis) }}">
            </div>

            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('anggota.profile.index') }}" class="btn btn-secondary">Kembali</a>

        </form>

    </div>

</div>
@endsection