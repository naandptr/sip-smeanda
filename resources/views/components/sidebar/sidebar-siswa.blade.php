<!-- Sidebar -->
<nav id="sidebarMenu" class="sidebar bg-white">
    <div class="sidebar-box">
        <!-- Header Sidebar -->
        <div class="sidebar-header container-fluid">
            <!-- Teks Menu di Kiri -->
            <h3 class="m-0" id="menuText">MENU</h3>
            <!-- Ikon Collapse di Kanan -->
            <button id="toggleSidebar" class="toggle-btn" type="button">
                <img src="{{ asset('img/collapsed-icon.png') }}" alt="Collapse" height="20" style="cursor: pointer; margin-left: auto;">
            </button>
        </div>
        <!-- Menu -->
        <div class="list-group list-group-flush mt-3 list-menu">
            <a href="/" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('/') ? 'active' : '' }}">
                <img src="{{ asset('img/dashboard-icon.png') }}" alt="dashboard" height="20" />
                <h4 class="ms-2 mb-0 fs-6 menu-text">Dashboard</h4>
            </a>
            <a href="{{ url('/siswa/info') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('siswa/info') ? 'active' : '' }}">
                <img src="{{ asset('img/info-icon.png') }}" alt="informasi prakerin" height="20" />
                <h4 class="ms-2 mb-0 fs-6 menu-text">Informasi Prakerin</h4>
            </a>
            <a href="{{ url('/siswa/dokumen') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('siswa/dokumen') ? 'active' : '' }}">
                <img src="{{ asset('img/dokumen-icon.png') }}" alt="dokumen prakerin" height="20" />
                <h4 class="ms-2 mb-0 fs-6 menu-text">Dokumen</h4>
            </a>
            <a href="{{ url('/siswa/absen') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('siswa/absen') ? 'active' : '' }}">
                <img src="{{ asset('img/absen-icon.png') }}" alt="absen harian" height="20" />
                <h4 class="ms-2 mb-0 fs-6 menu-text">Absen Harian</h4>
            </a>
            <a href="{{ url('/siswa/jurnal') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('siswa/jurnal') ? 'active' : '' }}">
                <img src="{{ asset('img/jurnal-icon.png') }}" alt="jurnal kegiatan" height="20" />
                <h4 class="ms-2 mb-0 fs-6 menu-text">Jurnal Kegiatan</h4>
            </a>
            <a href="{{ url('/siswa/nilai') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('siswa/nilai') ? 'active' : '' }}">
                <img src="{{ asset('img/nilai-icon.png') }}" alt="nilai" height="20" />
                <h4 class="ms-2 mb-0 fs-6 menu-text">Nilai</h4>
            </a>
            <a href="{{ url('/siswa/akun') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('siswa/akun') ? 'active' : '' }}">
                <img src="{{ asset('img/akun-icon.png') }}" alt="akun" height="20" />
                <h4 class="ms-2 mb-0 fs-6 menu-text">Akun</h4>
            </a>
        </div>
    </div>
</nav>
