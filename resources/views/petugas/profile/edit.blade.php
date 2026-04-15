@extends('petugas.layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow p-4" style="max-width:500px; margin:auto;">

        <h4>Edit Profile Petugas</h4>

        <form method="POST" action="{{ route('petugas.profile.update') }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>

            <div class="mb-3">
                <label>NIP</label>
                <input type="text" name="nip_petugas" class="form-control" value="{{ $user->nip_petugas ?? '' }}">
            </div>

            <button type="submit" class="btn btn-success w-100">
               Simpan
            </button>
        </form>

    </div>

</div>
@endsection