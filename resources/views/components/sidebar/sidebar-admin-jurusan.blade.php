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
            <a href="/?role=admin_jurusan" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('/') ? 'active' : '' }}">
                <img src="{{ asset('img/dashboard-icon.png') }}" alt="dashboard" height="20" />
                <h4 class="ms-2 mb-0 fs-6 menu-text">Dashboard</h4>
            </a>
            <a href="{{ url('/admin_jurusan/siswa?role=admin_jurusan') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('admin_jurusan/siswa') ? 'active' : '' }}">
                <img src="{{ asset('img/siswa-icon.png') }}" alt="data siswa" height="20" />
                <h4 class="ms-2 mb-0 fs-6 menu-text">Data Siswa</h4>
            </a>
            <a href="{{ url('/admin_jurusan/lokasi?role=admin_jurusan') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('admin_jurusan/lokasi') ? 'active' : '' }}">
                <img src="{{ asset('img/location-icon.png') }}" alt="data lokasi" height="20" />
                <h4 class="ms-2 mb-0 fs-6 menu-text">Data Lokasi</h4>
            </a>
            <a href="{{ url('/admin_jurusan/dokumen?role=admin_jurusan') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('admin_jurusan/dokumen') ? 'active' : '' }}">
                <img src="{{ asset('img/dokumen-icon.png') }}" alt="dokumen" height="20" />
                <h4 class="ms-2 mb-0 fs-6 menu-text">Dokumen</h4>
            </a>
            <a href="{{ url('/admin_jurusan/penetapan?role=admin_jurusan') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('admin_jurusan/penetapan') ? 'active' : '' }}">
                <img src="{{ asset('img/prakerin-icon.png') }}" alt="data penetapan" height="20" />
                <h4 class="ms-2 mb-0 fs-6 menu-text">Data Penetapan</h4>
            </a>
            <a href="{{ url('/admin_jurusan/nilai?role=admin_jurusan') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('admin_jurusan/nilai') ? 'active' : '' }}">
                <img src="{{ asset('img/nilai-icon.png') }}" alt="penilaian" height="20" />
                <h4 class="ms-2 mb-0 fs-6 menu-text">Penilaian</h4>
            </a>
            <a href="{{ url('/admin_jurusan/akun?role=admin_jurusan') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('admin_jurusan/akun') ? 'active' : '' }}">
                <img src="{{ asset('img/akun-icon.png') }}" alt="akun" height="20" />
                <h4 class="ms-2 mb-0 fs-6 menu-text">Akun</h4>
            </a>
        </div>
    </div>
</nav>
