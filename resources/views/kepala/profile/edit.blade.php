@extends('kepala.layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow p-4" style="max-width:500px; margin:auto;">

        <h4>Edit Profile Kepala</h4>

        <form method="POST" action="{{ route('kepala.profile.update') }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control"
                       value="{{ $user->name }}" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ $user->email }}" required>
            </div>

            <div class="mb-3">
                <label>NIP Kepala</label>
                <input type="text" name="nip_kepala" class="form-control"
                       value="{{ $user->nip_kepala ?? '' }}">
            </div>

            <button type="submit" class="btn btn-success w-100">
                Simpan
            </button>

        </form>

    </div>

</div>
@endsection