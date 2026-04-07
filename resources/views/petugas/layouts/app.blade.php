<!DOCTYPE html>
<html>
<head>
    <title>E-Perpus - Petugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="d-flex">

    {{-- Sidebar --}}
    @include('petugas.layouts.sidebar')

    {{-- Content --}}
    <div class="flex-grow-1 p-4">
        @yield('content')
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>