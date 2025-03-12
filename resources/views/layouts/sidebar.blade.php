<nav id="sidebarMenu" class="sidebar bg-white">
    <div class="sidebar-box">
        <!-- Header Sidebar -->
        <div class="sidebar-header container-fluid">
            <h3 class="m-0" id="menuText">MENU</h3>
            <button id="toggleSidebar" class="toggle-btn" type="button">
                <img src="{{ asset('img/collapsed-icon.png') }}" alt="Collapse" height="20" style="cursor: pointer; margin-left: auto;">
            </button>
        </div>

        <!-- Menu -->
        <div class="list-group list-group-flush mt-3 list-menu">
            @php
                $role = session('role', Auth::user()->role ?? 'siswa');
            @endphp


            <a href="{{ url('/dashboard') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('dashboard') ? 'active' : '' }}">
                <img src="{{ asset('img/dashboard-icon.png') }}" alt="dashboard" height="20" />
                <h4 class="ms-2 mb-0 fs-6 menu-text">Dashboard</h4>
            </a>
            

            @if($role == 'siswa')
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
                <a href="{{ url('/siswa/akun') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('siswa/akun') ? 'active' : '' }}">
                    <img src="{{ asset('img/akun-icon.png') }}" alt="akun" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Akun</h4>
                </a>
            @elseif($role == 'guru')
                <a href="{{ url('/guru/siswa') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('guru/siswa') ? 'active' : '' }}">
                    <img src="{{ asset('img/siswa-icon.png') }}" alt="siswa bimbingan" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Siswa Bimbingan</h4>
                </a>
                <a href="{{ url('/guru/absen') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('guru/absen') ? 'active' : '' }}">
                    <img src="{{ asset('img/absen-icon.png') }}" alt="absen harian" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Absen Harian</h4>
                </a>
                <a href="{{ url('/guru/jurnal') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('guru/jurnal') ? 'active' : '' }}">
                    <img src="{{ asset('img/jurnal-icon.png') }}" alt="jurnal kegiatan" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Jurnal Kegiatan</h4>
                </a>
                <a href="{{ url('/guru/akun') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('guru/akun') ? 'active' : '' }}">
                    <img src="{{ asset('img/akun-icon.png') }}" alt="akun" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Akun</h4>
                </a>
            @elseif($role == 'admin_jurusan')
                <a href="{{ url('/admin_jurusan/siswa') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('admin_jurusan/siswa') ? 'active' : '' }}">
                    <img src="{{ asset('img/siswa-icon.png') }}" alt="data siswa" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Data Siswa</h4>
                </a>
                <a href="{{ url('/admin_jurusan/lokasi') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('admin_jurusan/lokasi') ? 'active' : '' }}">
                    <img src="{{ asset('img/location-icon.png') }}" alt="data lokasi" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Data Lokasi</h4>
                </a>
                <a href="{{ url('/admin_jurusan/dokumen') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('admin_jurusan/dokumen') ? 'active' : '' }}">
                    <img src="{{ asset('img/dokumen-icon.png') }}" alt="dokumen" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Dokumen</h4>
                </a>
                <a href="{{ url('/admin_jurusan/pembimbing') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('admin_jurusan/pembimbing') ? 'active' : '' }}">
                    <img src="{{ asset('img/pembimbing-icon.png') }}" alt="penetapan pembimbing" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Penetapan Pembimbing</h4>
                </a>
                <a href="{{ url('/admin_jurusan/prakerin') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('admin_jurusan/prakerin') ? 'active' : '' }}">
                    <img src="{{ asset('img/prakerin-icon.png') }}" alt="penetapan siswa" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Penetapan Siswa</h4>
                </a>
                <a href="{{ url('/admin_jurusan/akun') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('admin_jurusan/akun') ? 'active' : '' }}">
                    <img src="{{ asset('img/akun-icon.png') }}" alt="akun" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Akun</h4>
                </a>
            @elseif($role == 'admin_utama')
                <a href="{{ url('/admin_utama/user') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('admin_utama/user') ? 'active' : '' }}">
                    <img src="{{ asset('img/siswa-icon.png') }}" alt="kelola user" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Kelola User</h4>
                </a>
                <a href="{{ url('/admin_utama/jurusan') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('admin_utama/jurusan') ? 'active' : '' }}">
                    <img src="{{ asset('img/jurusan-icon.png') }}" alt="kelola jurusan" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Kelola Jurusan</h4>
                </a>
                <a href="{{ url('/admin_utama/kelas') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('admin_utama/kelas') ? 'active' : '' }}">
                    <img src="{{ asset('img/dokumen-icon.png') }}" alt="kelola kelas" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Kelola Kelas</h4>
                </a>
                <a href="{{ url('/admin_utama/tahun_ajar') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ Request::is('admin_utama/tahun_ajar') ? 'active' : '' }}">
                    <img src="{{ asset('img/date-icon.png') }}" alt="kelola tahun ajaran" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Kelola Tahun Ajaran</h4>
                </a>
            @endif
        </div>
    </div>
</nav>
