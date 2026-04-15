@extends('anggota.layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow border-0 text-center p-4" 
         style="max-width:450px; margin:auto; border-radius:15px;">

        <!-- INISIAL -->
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
            {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
        </div>

        <!-- NAMA -->
        <h4 class="mt-3">{{ $user->name ?? '-' }}</h4>
        <p class="text-muted">Anggota Perpustakaan</p>

        <hr>

        <!-- DATA -->
        <div class="text-start mt-3">

            <p>
                <strong>Email:</strong><br>
                <span class="text-muted">
                    {{ $user->email ?? '-' }}
                </span>
            </p>

            <p>
                <strong>NIS:</strong><br>
                <span class="text-muted">
                    {{ $anggota->nis ?? '-' }}
                </span>
            </p>

        </div>

        <!-- BUTTON -->
        <a href="{{ route('anggota.profile.edit') }}" 
           class="btn btn-success mt-3 rounded-pill w-100">
           ✏️ Edit Profile
        </a>

    </div>

</div>
@endsection