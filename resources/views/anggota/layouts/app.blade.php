<!DOCTYPE html>
<html>
<head>
    <title>E-Perpus - Anggota</title>

    <!-- CSRF TOKEN (WAJIB) -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .main-content {
            min-height: 100vh;
        }

        .card-img-top {
            height: 220px;
            object-fit: cover;
        }
    </style>
</head>

<body>

@php
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

$notifCount = Auth::check() 
    ? Notifikasi::where('user_id', Auth::id())->where('dibaca', false)->count()
    : 0;

$notifikasis = Auth::check() 
    ? Notifikasi::where('user_id', Auth::id())->latest()->take(5)->get()
    : [];
@endphp

{{-- NAVBAR NOTIFIKASI --}}
<nav class="navbar navbar-light bg-white shadow-sm px-4">
    <div class="container-fluid d-flex justify-content-end">

        {{-- ICON NOTIFIKASI --}}
        <div class="dropdown">
            <a class="btn btn-light position-relative" data-bs-toggle="dropdown">
                <i class="bi bi-bell fs-5"></i>

                @if($notifCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $notifCount }}
                    </span>
                @endif
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
                <li class="dropdown-header">Notifikasi</li>

                @forelse($notifikasis as $n)
                    <li>
                        <a class="dropdown-item">
                            {{ $n->pesan }}
                        </a>
                    </li>
                @empty
                    <li>
                        <span class="dropdown-item text-muted">Tidak ada notifikasi</span>
                    </li>
                @endforelse

                <li><hr class="dropdown-divider"></li>

                <li>
                    <a class="dropdown-item text-center" href="{{ route('anggota.notifikasi.index') }}">
                        Lihat semua
                    </a>
                </li>
            </ul>
        </div>

    </div>
</nav>

<div class="d-flex">

    {{-- SIDEBAR --}}
    @include('anggota.layouts.sidebar')

    {{-- CONTENT --}}
    <div class="flex-grow-1 main-content p-4">

        <div class="container-fluid px-4">
            @yield('content')
        </div>

    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>