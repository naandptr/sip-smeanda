<!-- Sidebar -->
<nav id="sidebarMenu" class="sidebar bg-white">
    <div class="sidebar-box">
        <!-- Header Sidebar -->
        <div class="sidebar-header container-fluid">
            <!-- Teks Menu di Kiri -->
            <h3 class="m-0" id="menuText">MENU</h3>
            <!-- Ikon Collapse di Kanan -->
            <button id="toggleSidebar" class="toggle-btn" type="button">
                <img src="img/collapsed.jpg" alt="Collapse" height="20" style="cursor: pointer; margin-left: auto;">
            </button>
        </div>
        <!-- Menu -->
        <div class="list-group list-group-flush mt-3 list-menu">
            <a href="/?role=admin-utama" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('/') ? 'active' : '' }}">
                <img src="{{ asset('img/dashboard-icon.png') }}" alt="dashboard" height="20" />
                <h4 class="ms-2 mb-0 fs-6 menu-text">Dashboard</h4>
            </a>
            <a href="{{ url('/admin_utama/user?role=admin-utama') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('admin_utama/user') ? 'active' : '' }}">
                <img src="{{ asset('img/dashboard-icon.png') }}" alt="kelola user" height="20" />
                <h4 class="ms-2 mb-0 fs-6 menu-text">Kelola User</h4>
            </a>
            <a href="{{ url('/admin_utama/jurusan?role=admin-utama') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('admin_utama/jurusan') ? 'active' : '' }}">
                <img src="{{ asset('img/dashboard-icon.png') }}" alt="kelola jurusan" height="20" />
                <h4 class="ms-2 mb-0 fs-6 menu-text">Kelola Jurusan</h4>
            </a>
            <a href="{{ url('/admin_utama/kelas?role=admin-utama') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('admin_utama/kelas') ? 'active' : '' }}">
                <img src="{{ asset('img/dashboard-icon.png') }}" alt="kelola kelas" height="20" />
                <h4 class="ms-2 mb-0 fs-6 menu-text">Kelola Kelas</h4>
            </a>
            <a href="{{ url('/admin_utama/tahun_ajar?role=admin-utama') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('admin_utama/tahun_ajar') ? 'active' : '' }}">
                <img src="{{ asset('img/dashboard-icon.png') }}" alt="kelola tahun ajaran" height="20" />
                <h4 class="ms-2 mb-0 fs-6 menu-text">Kelola Tahun Ajaran</h4>
            </a>
        </div>
    </div>
</nav>
