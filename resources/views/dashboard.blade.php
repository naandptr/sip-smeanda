@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard">
    <h1>Selamat Datang</h1>

    @php
        use App\Models\User;
        $role = Auth::user()->role ?? User::ROLE_SISWA; // Gunakan konstanta default
    @endphp


    {{-- Dashboard Siswa --}}
    @if ($role === User::ROLE_SISWA)
    <div class="card-container">
        <div class="card-item">
            <h4>Nomor Induk Siswa</h4>
            <div class="detail-card">
                <img src="img/nis-icon.png" alt="">
                <h2>0031652858</h2>
            </div>
        </div>
        <div class="card-item">
            <h4>Lokasi Prakerin</h4>
            <div class="detail-card">
                <img src="img/lokasi-icon.png" alt="">
                <div class="detail-lokasi">
                    <h2>TVRI Jambi</h2>
                    <p>Telanaipura</>
                </div>
            </div>
        </div>
        <div class="card-item">
            <h4>Guru Pembimbing</h4>
            <div class="detail-card">
                <img src="img/guru-icon.png" alt="">
                <h2>Mulyono</h2>
            </div>
        </div>
    </div>
    <div class="header">
        <h1>Alur Prakerin</h1>
    </div>
    <div class="card-container">
        <div class="card-item">
            <ol class="list-item">
                <li>Lampirkan CV dan portofolio di halaman dokumen</li>
                <li>Datang tepat waktu dan mengikuti aturan DUDI</li>
                <li>Mengerjakan tugas yang diberikan dengan penuh tanggung jawab</li>
                <li>Jangan lupa mengisi absen datang dan pulang setiap hari</li>
                <li>Mencatat kegiatan dalam jurnal prakerin setiap harinya</li>
                <li>Lampirkan laporan dan sertifikat prakerin di halaman dokumen setelah masa prakerin berakhir</li>
            </ol>
        </div>
    </div>
    
    {{-- Dashboard Guru --}}
    @elseif ($role === User::ROLE_GURU)
        <div class="card-container">
            <div class="card-item">
                <h4>Siswa Bimbingan</h4>
                <div class="detail-card">
                    <img src="img/nis-icon.png" alt="">
                    <h2>10 Siswa</h2>
                </div>
            </div>
            <div class="card-item">
                <h4>Lokasi Prakerin</h4>
                <div class="detail-card">
                    <img src="img/lokasi-icon.png" alt="">
                    <h2>3 Lokasi Prakerin</h2>
                </div>
            </div>
        </div>

    {{-- Dashboard Admin Jurusan --}}
    @elseif ($role === User::ROLE_ADMIN_JURUSAN)
        <div class="card-container">
            <div class="card-item">
                <h4>Siswa Jurusan</h4>
                <div class="detail-card">
                    <img src="img/nis-icon.png" alt="">
                    <h2>{{ $totalSiswa }} Siswa</h2>
                </div>
            </div>
            <div class="card-item">
                <h4>Lokasi Prakerin</h4>
                <div class="detail-card">
                    <img src="img/lokasi-icon.png" alt="">
                    <h2>{{ $totalLokasiPrakerin }} Lokasi Prakerin</h2>
                </div>
            </div>
        </div>

    {{-- Dashboard Admin Utama --}}
    @elseif ($role === User::ROLE_ADMIN_UTAMA)
        <div class="card-container">
            <div class="card-item">
                <h4>User</h4>
                <div class="detail-card">
                    <img src="img/nis-icon.png" alt="">
                    <h2>{{ $totalUsers }} User</h2>
                </div>
            </div>
            <div class="card-item">
                <h4>Jurusan</h4>
                <div class="detail-card">
                    <img src="img/lokasi-icon.png" alt="">
                    <h2>{{ $totalJurusan }} Jurusan</h2>
                </div>
            </div>
            <div class="card-item">
                <h4>Kelas</h4>
                <div class="detail-card">
                    <img src="img/lokasi-icon.png" alt="">
                    <h2>{{ $totalKelas }} Kelas</h2>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
