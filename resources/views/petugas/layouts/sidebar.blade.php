<div class="text-white p-3 d-flex flex-column sidebar" style="width: 250px; min-height: 100vh;">

    <!-- LOGO -->
    <div class="d-flex justify-content-center align-items-center mb-4" style="height:120px;">
        <img src="{{ asset('image/logo.png') }}" alt="Logo" style="max-width:260px; object-fit:contain;">
    </div>

    <ul class="nav flex-column">

        {{-- Dashboard --}}
        <li class="nav-item mb-2">
            <a href="{{ route('petugas.dashboard') }}" 
               class="nav-link sidebar-link {{ request()->is('petugas/dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>

        {{-- Peminjaman --}}
        <li class="nav-item mb-2">
            <a href="{{ route('petugas.peminjaman.index') }}" 
               class="nav-link sidebar-link {{ request()->is('petugas/peminjaman*') ? 'active' : '' }}">
                <i class="bi bi-journal-plus"></i> Peminjaman
            </a>
        </li>

        {{-- Pengembalian --}}
        <li class="nav-item mb-2">
            <a href="{{ route('petugas.pengembalian') }}" 
               class="nav-link sidebar-link {{ request()->is('petugas/pengembalian*') ? 'active' : '' }}">
                <i class="bi bi-arrow-return-left"></i> Pengembalian
            </a>
        </li>

        {{-- Daftar Buku --}}
        <li class="nav-item mb-2">
            <a href="{{ route('petugas.buku.index') }}" 
               class="nav-link sidebar-link {{ request()->is('petugas/buku*') ? 'active' : '' }}">
                <i class="bi bi-book"></i> Daftar Buku
            </a>
        </li>

        {{-- Profile --}}
        <li class="nav-item mb-2">
            <a href="{{ route('petugas.profile') }}" 
               class="nav-link sidebar-link {{ request()->is('petugas/profile') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i> Profile
            </a>
        </li>

        {{-- Logout --}}
        <li class="nav-item mt-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="nav-link sidebar-link border-0 bg-transparent w-100 text-start text-white">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </li>

    </ul>
</div>

{{-- STYLE --}}
<style>
.sidebar{
    background-color: #a0e09b;
}
.sidebar-link {
    color: white;
    border-radius: 8px;
    transition: 0.3s;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Hover effect */
.sidebar-link:hover {
    background-color: #5faa58;
    padding-left: 10px;
}

/* Active */
.sidebar-link.active {
    background-color: #2faa4de5;
    font-weight: bold;
}
</style>