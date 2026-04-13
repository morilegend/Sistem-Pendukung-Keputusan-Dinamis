<ul class="navbar-nav sidebar accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/Pengguna') }}">
        <div class="sidebar-brand-text mx-3 text-uppercase small">{{ Auth::user()->nama }}</div>
    </a>

    <div class="sidebar-heading mt-4 mb-2 text-xs text-uppercase text-gray-500 px-4">Menu Utama</div>

    <!-- Dashboard -->
    <li class="nav-item {{ Request::is('Pengguna') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/Pengguna/') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <div class="sidebar-heading mt-4 mb-2 text-xs text-uppercase text-gray-500 px-4">Manajemen</div>

    <!-- Kategori Kriteria -->
    <li
        class="nav-item {{ Request::is('Pengguna/kategori_kriteria') || Request::is('Pengguna/kriteria/*') || Request::is('Pengguna/sub_kriteria/*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/Pengguna/kategori_kriteria') }}">
            <i class="fas fa-fw fa-tasks"></i>
            <span>Kategori Kriteria</span>
        </a>
    </li>

    <!-- Kategori Alternatif -->
    <li
        class="nav-item {{ Request::is('Pengguna/kategori_alternatif') || Request::is('Pengguna/alternatif/*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/Pengguna/kategori_alternatif') }}">
            <i class="fas fa-fw fa-clone"></i>
            <span>Kategori Alternatif</span>
        </a>
    </li>

    <!-- Penilaian -->
    <li
        class="nav-item {{ Request::is('Pengguna/kategori_penilaian') || Request::is('Pengguna/penilaian/*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/Pengguna/kategori_penilaian') }}">
            <i class="fas fa-fw fa-edit"></i>
            <span>Penilaian</span>
        </a>
    </li>

    <div class="sidebar-heading mt-4 mb-2 text-xs text-uppercase text-gray-500 px-4">Hasil & Analisis</div>

    <!-- Perhitungan -->
    <li class="nav-item {{ Request::is('Pengguna/perhitungan') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/Pengguna/perhitungan') }}">
            <i class="fas fa-fw fa-book"></i>
            <span>Perhitungan</span>
        </a>
    </li>

    <!-- Hasil -->
    <li class="nav-item {{ Request::is('Pengguna/hasil') || Request::is('Pengguna/hasil/*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/Pengguna/hasil') }}">
            <i class="fas fa-fw fa-trophy"></i>
            <span>Hasil Ranking</span>
        </a>
    </li>

    <!-- Anggota -->
    <li class="nav-item {{ Request::is('Pengguna/anggota') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/Pengguna/anggota') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Anggota</span>
        </a>
    </li>

    <div class="sidebar-heading mt-4 mb-2 text-xs text-uppercase text-gray-500 px-4">Akun</div>

    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>

</ul>


<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Apakah Anda yakin ingin keluar?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary shadow-sm" type="button" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i> Batal
                </button>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>