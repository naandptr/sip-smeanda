@php
    use Illuminate\Support\Facades\Auth;
    use App\Models\User;

    $user = Auth::user();
    $nama = 'User'; // Default jika tidak ada user yang login

    if ($user) {
        if ($user->role === User::ROLE_ADMIN_UTAMA) {
            $nama = $user->username; 
        } elseif ($user->role === 'Siswa') {
            $nama = $user->siswa->nama ?? 'User';
        } elseif ($user->role === 'Guru') {
            $nama = $user->pembimbing->nama ?? 'User';
        } elseif ($user->role === 'Admin Jurusan') {
            $nama = $user->adminJurusan->nama ?? 'User';
        }
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
            {{-- <button class="btn-logout">Logout</button> --}}
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>

