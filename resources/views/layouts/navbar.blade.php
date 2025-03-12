@php
    $role = session('role', 'siswa'); // Default ke 'siswa' jika belum ada session
    $nama = '';

    // Menentukan nama berdasarkan role
    switch ($role) {
        case 'siswa':
            $nama = 'Arslan Allen';
            break;
        case 'guru':
            $nama = 'Siti Menenun';
            break;
        case 'admin_jurusan':
            $nama = 'Admin Animasi';
            break;
        case 'admin_utama':
            $nama = 'Admin Utama';
            break;
        default:
            $nama = 'User';
            break;
    }
@endphp

<nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top w-100" style="padding-top: 10px; padding-bottom: 10px;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div id="brand" class="d-flex align-items-center">
            <img
                src="{{ asset('img/logo-icon.png') }}"
                height="49"
                alt="Logo SMKN 2"
                loading="lazy"
            />
            <h5 class="ms-2 mb-0">SISTEM INFORMASI PRAKERIN</h5>
        </div>       

        <div id="avatar" class="d-flex align-items-center">
            <img
                src="{{ asset('img/user-icon.png') }}"
                class="rounded-circle"
                height="32"
                alt="Avatar"
                loading="lazy"
            />
            <h5 class="ms-2 mb-0">{{ $nama }}</h5>
            <button class="btn-logout">Logout</button>
        </div>
    </div>
</nav>

