<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.header')
</head>
<body>
    

    <!-- Grid Container -->
    <div class="layout">
        <!-- Navbar -->
        @include('layouts.navbar')
        
        <!-- Sidebar -->
        {{-- @if($role == 'siswa')
        @include('components.sidebar.siswa')
        @elseif($role == 'guru')
        @include('components.sidebar.guru')
        @elseif($role == 'admin_jurusan')
        @include('components.sidebar.admin-jurusan')
        @elseif($role == 'admin_utama')
        @include('components.sidebar.admin-utama')
        @endif --}}
        @include('layouts.sidebar')
            
        

        <!-- Main Content -->
        <main class="content">
            @yield('content')
        </main>
    </div>
    @include('layouts.footer')
</body>
</html>

