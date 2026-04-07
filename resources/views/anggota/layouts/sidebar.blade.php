<div class="text-white p-3 d-flex flex-column sidebar" style="width: 250px; min-height: 100vh;">

    <!-- LOGO -->
    <div class="d-flex justify-content-center align-items-center mb-4" style="height:120px;">
        <img src="{{ asset('image/logo.png') }}" alt="Logo" style="max-width:260px; object-fit:contain;">
    </div>

    <ul class="nav flex-column">

        {{-- Dashboard --}}
        <li class="nav-item mb-2">
            <a href="/anggota/dashboard" 
               class="nav-link sidebar-link {{ request()->is('anggota/dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>

        {{-- Riwayat Peminjaman --}}
        <li class="nav-item mb-2">
            <a href="/anggota/riwayat" 
               class="nav-link sidebar-link {{ request()->is('anggota/riwayat*') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Riwayat Peminjaman
            </a>
        </li>

        {{-- Katalog Buku --}}
        <li class="nav-item mb-2">
            <a href="/anggota/buku" 
               class="nav-link sidebar-link {{ request()->is('anggota/buku*') ? 'active' : '' }}">
                <i class="bi bi-book"></i> Katalog Buku
            </a>
        </li>

        {{-- Profile --}}
        <li class="nav-item mb-2">
            <a href="/anggota/profile" 
               class="nav-link sidebar-link {{ request()->is('anggota/profile') ? 'active' : '' }}">
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