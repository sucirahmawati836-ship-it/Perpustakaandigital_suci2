<div class="text-white p-3 d-flex flex-column sidebar" style="width: 250px; min-height: 100vh;">

    <!-- LOGO -->
    <div class="d-flex justify-content-center align-items-center mb-4" style="height:120px;">
      <img src="{{ asset('image/logo.png') }}" alt="Logo" style="max-width:260px; object-fit:contain;">
    </div>
    <ul class="nav flex-column">

        {{-- Dashboard --}}
        <li class="nav-item mb-2">
            <a href="/dashboard" 
               class="nav-link sidebar-link {{ request()->is('dashboard') ? 'active' : '' }}">
                🏠 Dashboard
            </a>
        </li>

        {{-- Transaksi --}}
        <li class="nav-item mb-2">
            <a href="/transaki" 
               class="nav-link sidebar-link {{ request()->is('transaksi*') ? 'active' : '' }}">
                🔄 Transaksi
            </a>
        </li>

        {{-- Daftar Pengguna --}}
        <li class="nav-item mb-2">
            <a href="{{ route('akun.index') }}" 
               class="nav-link sidebar-link {{ request()->routeIs('akun.index') ? 'active' : '' }}">
                👥 Daftar Pengguna
            </a>
        </li>

        {{-- Daftar Buku --}}
        <li class="nav-item mb-2">
            <a href="{{ route('akun.index') }}" 
               class="nav-link sidebar-link {{ request()->routeIs('akun.view') ? 'active' : '' }}">
                📚 Daftar Buku
            </a>
        </li>

        {{-- Profile --}}
        <li class="nav-item mb-2">
            <a href="/profile" 
               class="nav-link sidebar-link {{ request()->is('profile') ? 'active' : '' }}">
                👤 Profile
            </a>
        </li>

    </ul>

</div>

{{-- STYLE --}}
<style>
.sidebar{
    background-color: #77aa73;
}
.sidebar-link {
    color: white;
    border-radius: 8px;
    transition: 0.3s;
    display: flex;
    align-items: center;
}

/* Hover effect */
.sidebar-link:hover {
    background-color: #44963d;
    padding-left: 10px;
}

/* Active (halaman sekarang) */
.sidebar-link.active {
    background-color: #0f9630;
    font-weight: bold;
}
</style>