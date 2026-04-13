<ul class="navbar-nav sidebar accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/admin') }}">
        <div class="sidebar-brand-text mx-3">{{ Auth::user()->nama }}</div>
    </a>

    <div class="sidebar-heading mt-4 mb-2 text-xs text-uppercase text-gray-500 px-4">Utama</div>

    <!-- Dashboard -->
    <li class="nav-item {{ Request::is('admin') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/admin') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <div class="sidebar-heading mt-4 mb-2 text-xs text-uppercase text-gray-500 px-4">Pengguna</div>

    <!-- User Management -->
    <li class="nav-item {{ Request::is('admin/users*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/admin/users') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Kelola Pengguna</span>
        </a>
    </li>

    <div class="sidebar-heading mt-4 mb-2 text-xs text-uppercase text-gray-500 px-4">Sistem</div>

    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Keluar</span>
        </a>
    </li>
</ul>

<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>