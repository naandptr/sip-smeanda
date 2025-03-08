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
            <a href="/?role=guru" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('/') ? 'active' : '' }}">
                <img src="{{ asset('img/dashboard-icon.png') }}" alt="dashboard" height="20" />
                <h4 class="ms-2 mb-0 fs-6 menu-text">Dashboard</h4>
            </a>
            <a href="{{ url('/guru/siswa?role=guru') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('guru/siswa') ? 'active' : '' }}">
                <img src="{{ asset('img/dashboard-icon.png') }}" alt="siswa bimbingan" height="20" />
                <h4 class="ms-2 mb-0 fs-6 menu-text">Siswa Bimbingan</h4>
            </a>
            <a href="{{ url('/guru/absen?role=guru') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('guru/absen') ? 'active' : '' }}">
                <img src="{{ asset('img/dashboard-icon.png') }}" alt="absen harian" height="20" />
                <h4 class="ms-2 mb-0 fs-6 menu-text">Absen Harian</h4>
            </a>
            <a href="{{ url('/guru/jurnal?role=guru') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('guru/jurnal') ? 'active' : '' }}">
                <img src="{{ asset('img/dashboard-icon.png') }}" alt="jurnal kegiatan" height="20" />
                <h4 class="ms-2 mb-0 fs-6 menu-text">Jurnal Kegiatan</h4>
            </a>
            <a href="{{ url('/guru/akun?role=guru') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('guru/akun') ? 'active' : '' }}">
                <img src="{{ asset('img/dashboard-icon.png') }}" alt="akun" height="20" />
                <h4 class="ms-2 mb-0 fs-6 menu-text">Akun</h4>
            </a>
        </div>
    </div>
</nav>
