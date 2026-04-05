@extends('kepala.layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">Profile Kepala Perpustakaan</h3>

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

        <h5 class="mt-3">{{ $kepala->user->name ?? '-' }}</h5>
        <p class="text-muted">Kepala Perpustakaan</p>

        <hr>

        <p><strong>Email:</strong> {{ $kepala->user->email ?? '-' }}</p>
        <p><strong>NIP:</strong> {{ $kepala->nip_KepalaPerpus ?? '-' }}</p>

        @if($kepala)
        <a href="{{ route('kepala.profile.edit', $kepala->id) }}" class="btn btn-primary mt-3">
            Edit Profile
        </a>
        @endif

    </div>
    

</div>
@endsection