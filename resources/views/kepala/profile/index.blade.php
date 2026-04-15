@extends('kepala.layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow border-0 text-center p-4" style="max-width:450px; margin:auto; border-radius:15px;">

        {{-- INISIAL --}}
        <div style="
            width:90px;
            height:90px;
            background:#198754;
            color:white;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:35px;
            margin:auto;
        ">
            {{ $inisial }}
        </div>

        {{-- NAMA --}}
        <h4 class="mt-3">{{ $user->name }}</h4>
        <p class="text-muted">Kepala Perpustakaan</p>

        <hr>

        {{-- DATA --}}
        <div class="text-start mt-3">

            <p>
                <strong>Email:</strong><br>
                <span class="text-muted">{{ $user->email }}</span>
            </p>

            <p>
                <strong>NIP:</strong><br>
                <span class="text-muted">{{ $user->nip_kepala ?? '-' }}</span>
            </p>

        </div>

        {{-- BUTTON --}}
        <a href="{{ route('kepala.profile.edit') }}"
           class="btn btn-success mt-3 rounded-pill w-100">
           ✏️ Edit Profile
        </a>

    </div>

</div>
@endsection