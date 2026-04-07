@extends('anggota.layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">Profile Anggota</h3>

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

        <h5 class="mt-3">{{ $anggota->user->name ?? '-' }}</h5>
        <p class="text-muted">Anggota</p>

        <hr>

        <p><strong>Email:</strong> {{ $anggota->user->email ?? '-' }}</p>
        <p><strong>NIS:</strong> {{ $anggota->nis ?? '-' }}</p>

        @if($anggota)
        <a href="{{ route('anggota.profile.edit', $anggota->id) }}" class="btn btn-primary mt-3">
            Edit Profile
        </a>
        @endif

    </div>
    

</div>
@endsection