@extends('petugas.layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">Profile Petugas</h3>

    <div class="card shadow p-4 text-center" style="max-width: 400px; margin:auto;">

        {{-- INISIAL --}}
        <div style="
            width: 80px;
            height: 80px;
            background: #0d6efd;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin: auto;
        ">
            {{ $inisial }}
        </div>

        <h5 class="mt-3">{{ $petugas->user->name ?? '-' }}</h5>
        <p class="text-muted">Petugas</p>

        <hr>

        <p><strong>Email:</strong> {{ $petugas->user->email ?? '-' }}</p>
        <p><strong>NIP:</strong> {{ $petugas->nip_petugas?? '-' }}</p>

        @if($petugas)
        <a href="{{ route('petugas.profile.edit', $petugas->id) }}" class="btn btn-primary mt-3">
            Edit Profile
        </a>
        @endif

    </div>
    

</div>
@endsection