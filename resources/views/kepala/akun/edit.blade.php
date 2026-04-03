@extends('layouts.app')

@section('content')
<div class="p-4">
    <h3 class="mb-3">Edit Akun - {{ $user->name }}</h3>

    <form action="{{ route('kepala.akun.update', $user->id) }}" method="POST">
        @method('PUT')
        @csrf

        <div class="mb-3">
            <label class="form-label">Level</label>
            <input type="text" class="form-control" value="{{ ucfirst($user->level) }}" disabled>
            <small class="text-muted">Level tidak bisa diubah</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama *</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Email *</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <hr>

        @if($user->level == 'anggota' && $user->anggota)
        <h5 class="mb-2">Data Anggota</h5>
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">NIS *</label>
                <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis', $user->anggota->nis) }}">
                @error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col">
                <label class="form-label">Kelas *</label>
                <input type="text" name="kelas" class="form-control @error('kelas') is-invalid @enderror" value="{{ old('kelas', $user->anggota->kelas) }}">
                @error('kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $user->anggota->alamat) }}">
        </div>
        @endif

        @if($user->level == 'petugas' && $user->petugas)
        <h5 class="mb-2">Data Petugas</h5>
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">NIP</label>
                <input type="text" name="nip_petugas" class="form-control @error('nip_petugas') is-invalid @enderror" value="{{ old('nip_petugas', $user->petugas->nip_petugas) }}">
                @error('nip_petugas')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col">
                <label class="form-label">No HP</label>
                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $user->petugas->no_hp) }}">
            </div>
        </div>
        @endif

        @if($user->level == 'kepala' && $user->kepala)
        <h5 class="mb-2">Data Kepala Perpus</h5>
        <div class="mb-3">
            <label class="form-label">NIP</label>
            <input type="text" name="nip_KepalaPerpus" class="form-control @error('nip_KepalaPerpus') is-invalid @enderror" value="{{ old('nip_KepalaPerpus', $user->kepala->nip_KepalaPerpus) }}">
            @error('nip_KepalaPerpus')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        @endif

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('kepala.akun.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection