<!DOCTYPE html>
<html lang="en">
<head>
    @include('components.header')
</head>
<body>
    @php
        $role = request()->get('role', 'siswa');
    @endphp

    <!-- Grid Container -->
    <div class="layout">
        <!-- Navbar -->
        <x-navbar></x-navbar>
        
        <!-- Sidebar -->
        @if($role == 'siswa')
        @include('components.sidebar.sidebar-siswa')
        @elseif($role == 'guru')
        @include('components.sidebar.sidebar-guru')
        @elseif($role == 'admin_jurusan')
        @include('components.sidebar.sidebar-admin-jurusan')
        @elseif($role == 'admin_utama')
        @include('components.sidebar.sidebar-admin-utama')
        @endif

        <!-- Main Content -->
        <main class="content">
            @yield('content')
        </main>
    </div>
    <x-footer></x-footer>
</body>
</html>

