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
                use App\Models\User;
                $role = Auth::user()->role ?? User::ROLE_SISWA;
            @endphp


            <a href="{{ url('/dashboard') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <img src="{{ asset('img/dashboard-icon.png') }}" alt="dashboard" height="20" />
                <h4 class="ms-2 mb-0 fs-6 menu-text">Beranda</h4>
            </a>
            

            @if ($role === User::ROLE_SISWA)
                <a href="{{ route('siswa.info') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ request()->routeIs('siswa.info') ? 'active' : '' }}">
                    <img src="{{ asset('img/info-icon.png') }}" alt="informasi prakerin" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Informasi Prakerin</h4>
                </a>
                <a href="{{ route('siswa.dokumen') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ request()->routeIs('siswa.dokumen') ? 'active' : '' }}">
                    <img src="{{ asset('img/dokumen-icon.png') }}" alt="dokumen prakerin" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Dokumen</h4>
                </a>
                <a href="{{ route('siswa.absen') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ request()->routeIs('siswa.absen') ? 'active' : '' }}">
                    <img src="{{ asset('img/absen-icon.png') }}" alt="absen harian" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Presensi Harian</h4>
                </a>
                <a href="{{ route('siswa.jurnal') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ request()->routeIs('siswa.jurnal') ? 'active' : '' }}">
                    <img src="{{ asset('img/jurnal-icon.png') }}" alt="jurnal kegiatan" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Jurnal Kegiatan</h4>
                </a>
                <a href="{{ route('akun.show') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ request()->routeIs(['akun.show', 'akun.show.ganti_password']) ? 'active' : '' }}">
                    <img src="{{ asset('img/akun-icon.png') }}" alt="dashboard" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Akun</h4>
                </a>

            @elseif ($role === User::ROLE_GURU)
                <a href="{{ route('guru.siswa') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ request()->routeIs('guru.siswa') ? 'active' : '' }}">
                    <img src="{{ asset('img/siswa-icon.png') }}" alt="siswa bimbingan" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Siswa Bimbingan</h4>
                </a>
                <a href="{{ route('guru.absen') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ request()->routeIs(['guru.absen', 'absen-detail.guru']) ? 'active' : '' }}">
                    <img src="{{ asset('img/absen-icon.png') }}" alt="absen harian" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Presensi Harian</h4>
                </a>
                <a href="{{ route('guru.jurnal') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ request()->routeIs(['guru.jurnal', 'jurnal.detail']) ? 'active' : '' }}">
                    <img src="{{ asset('img/jurnal-icon.png') }}" alt="jurnal kegiatan" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Jurnal Kegiatan</h4>
                </a>
                <a href="{{ route('guru.nilai') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ request()->routeIs(['guru.nilai', 'nilai.form']) ? 'active' : '' }}">
                    <img src="{{ asset('img/nilai-icon.png') }}" alt="nilai" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Penilaian</h4>
                </a>
                <a href="{{ route('akun.show') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ request()->routeIs(['akun.show', 'akun.show.ganti_password']) ? 'active' : '' }}">
                    <img src="{{ asset('img/akun-icon.png') }}" alt="dashboard" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Akun</h4>
                </a>
                
            @elseif ($role === User::ROLE_ADMIN_JURUSAN)
                <a href="{{ route('jurusan.siswa') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ request()->routeIs('jurusan.siswa') ? 'active' : '' }}">
                    <img src="{{ asset('img/siswa-icon.png') }}" alt="data siswa" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Data Siswa</h4>
                </a>
                <a href="{{ route('jurusan.dokumen') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ request()->routeIs('jurusan.dokumen') ? 'active' : '' }}">
                    <img src="{{ asset('img/dokumen-icon.png') }}" alt="dokumen" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Dokumen</h4>
                </a>
                <a href="{{ route('jurusan.dudi-jurusan') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ request()->routeIs('jurusan.dudi-jurusan') ? 'active' : '' }}">
                    <img src="{{ asset('img/pembimbing-icon.png') }}" alt="penetapan dudi" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Penetapan DUDI</h4>
                </a>
                <a href="{{ route('jurusan.prakerin') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ request()->routeIs('jurusan.prakerin') ? 'active' : '' }}">
                    <img src="{{ asset('img/prakerin-icon.png') }}" alt="penetapan siswa" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Penetapan Siswa</h4>
                </a>
                <a href="{{ route('akun.show') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ request()->routeIs(['akun.show', 'akun.show.ganti_password']) ? 'active' : '' }}">
                    <img src="{{ asset('img/akun-icon.png') }}" alt="dashboard" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Akun</h4>
                </a>

            @elseif ($role === User::ROLE_ADMIN_UTAMA)
                <a href="{{ route('admin.user') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ request()->routeIs('admin.user') ? 'active' : '' }}">
                    <img src="{{ asset('img/siswa-icon.png') }}" alt="kelola user" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Kelola Pengguna</h4>
                </a>
                <a href="{{ route('admin.lokasi') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ request()->routeIs('admin.lokasi') ? 'active' : '' }}">
                    <img src="{{ asset('img/location-icon.png') }}" alt="data lokasi" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Kelola Lokasi</h4>
                </a>
                <a href="{{ route('admin.jurusan') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ request()->routeIs('admin.jurusan') ? 'active' : '' }}">
                    <img src="{{ asset('img/jurusan-icon.png') }}" alt="kelola jurusan" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Kelola Jurusan</h4>
                </a>
                <a href="{{ route('admin.kelas') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ request()->routeIs('admin.kelas') ? 'active' : '' }}">
                    <img src="{{ asset('img/dokumen-icon.png') }}" alt="kelola kelas" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Kelola Kelas</h4>
                </a>
                <a href="{{ route('admin.tahun-ajar') }}" class="menu d-flex align-items-center mb-2 p-2 rounded {{ request()->routeIs('admin.tahun-ajar') ? 'active' : '' }}">
                    <img src="{{ asset('img/date-icon.png') }}" alt="kelola tahun ajaran" height="20" />
                    <h4 class="ms-2 mb-0 fs-6 menu-text">Kelola Tahun Ajaran</h4>
                </a>
            @endif
        </div>
    </div>
</nav>
