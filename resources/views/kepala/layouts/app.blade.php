<!DOCTYPE html>
<html>
<head>
    <title>E-Perpus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

     <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

<div class="d-flex">

    {{-- Sidebar --}}
    @include('kepala.layouts.sidebar')

    {{-- Content --}}
    <div class="flex-grow-1 p-4">
        @yield('content')
    </div>

</div>

</body>
</html>