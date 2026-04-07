<!DOCTYPE html>
<html>
<head>
    <title>E-Perpus - Anggota</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        /* Biar layout lebih rapi */
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

<div class="d-flex">

    {{-- SIDEBAR --}}
    @include('anggota.layouts.sidebar')

    {{-- CONTENT --}}
    <div class="flex-grow-1 main-content p-4">

        <!-- INI KUNCI BIAR GA KEGEDEAN / KEKECILAN -->
        <div class="container-fluid px-4">

            @yield('content')

        </div>

    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>