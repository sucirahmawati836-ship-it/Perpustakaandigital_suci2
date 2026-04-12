<div class="text-white p-3 d-flex flex-column sidebar" style="width: 250px; min-height: 100vh;">

    <!-- LOGO -->
    <div class="d-flex justify-content-center align-items-center mb-4" style="height:120px;">
      <img src="{{ asset('image/logo_perpus.png') }}" alt="Logo" style="max-width:260px; object-fit:contain;">
    </div>

    <ul class="nav flex-column">

        {{-- Dashboard --}}
        <li class="nav-item mb-2">
            <a href="{{ route('kepala.dashboard') }}" 
              class="nav-link sidebar-link {{ request()->routeIs('kepala.dashboard') ? 'active' : '' }}">
               <i class="bi bi-speedometer2"></i> Dashboard
          </a>
        </li>

        {{-- Laporan --}}
        <li class="nav-item mb-2">
            <a href="{{ route('kepala.laporan.index') }}" 
               class="nav-link sidebar-link {{ request()->is('Laporan*') ? 'active' : '' }}">
                <i class="bi bi-arrow-left-right"></i> Laporan
            </a>
        </li>

        {{-- Daftar Pengguna --}}
        <li class="nav-item mb-2">
            <a href="{{ route('kepala.akun.index') }}" 
               class="nav-link sidebar-link {{ request()->routeIs('kepala.akun.index', 'kepala.akun.create', 'kepala.akun.edit', 'kepala.akun.view') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Daftar Pengguna
            </a>
        </li>

        {{-- Daftar Buku --}}
        <li class="nav-item mb-2">
            <a href="{{ route('kepala.buku.index') }}" 
               class="nav-link sidebar-link {{ request()->routeIs('kepala.buku.index', 'kepala.buku.edit', 'kepala.buku.create') ? 'active' : '' }}">
                <i class="bi bi-journal-bookmark-fill"></i> Daftar Buku
            </a>
        </li>

        {{-- Profile --}}
        <li class="nav-item mb-2">
            <a href="{{ route('kepala.profile.index') }}" 
                class="nav-link sidebar-link {{ request()->routeIs('kepala.profile.index') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i> Profile
            </a>
        </li>

        {{-- Logout --}}
       <li class="nav-item mt-4">
         <form action="{{ route('logout') }}" method="POST">
        @csrf
         <button type="submit" class="nav-link sidebar-link border-0 bg-transparent w-100 text-start">
            <i class="bi bi-box-arrow-right"></i> Logout
         </button>
        </form>
</li>

    </ul>


</div>

{{-- STYLE --}}
<style>
.sidebar{
    background-color: #064E3B;
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
    background-color: #065F46;
    padding-left: 10px;
}

/* Active */
.sidebar-link.active {
    background-color: #F59E0B;
    font-weight: bold;
}
</style>