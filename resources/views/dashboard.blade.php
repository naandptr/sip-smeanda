@php 
    $page_name = 'dashboard'; 
@endphp

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard">
    <h1>Selamat Datang</h1>

    @php
        use App\Models\User;
        $role = Auth::user()->role ?? User::ROLE_SISWA; 
    @endphp


    {{-- Dashboard Siswa --}}
    @if ($role === User::ROLE_SISWA)
    <div class="card-container">
        <div class="card-item">
            <h4>Nomor Induk Siswa</h4>
            <div class="detail-card">
                <img src="img/nis-icon.png" alt="">
                <h2>{{ $siswa->nis ?? '-' }}</h2>
            </div>
        </div>
        <div class="card-item">
            <h4>Lokasi Prakerin</h4>
            <div class="detail-card">
                <img src="img/lokasi-icon.png" alt="">
                <div class="detail-lokasi">
                    <h2>{{ $penetapan->dudiJurusan->dudi->nama_dudi ?? '-' }}</h2>
                    <p>{{ $penetapan->dudiJurusan->dudi->alamat ?? '-' }}</>
                </div>
            </div>
        </div>
        <div class="card-item">
            <h4>Guru Pembimbing</h4>
            <div class="detail-card">
                <img src="img/guru-icon.png" alt="">
                <h2>{{ $penetapan->dudiJurusan->pembimbing->nama ?? '-' }}</h2>
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
                <li>Jangan lupa mengisi presensi datang dan pulang setiap hari</li>
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
                    <h2>{{ $totalSiswaBimbingan }}  Siswa</h2>
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

    {{-- Dashboard Admin Jurusan --}}
    @elseif ($role === User::ROLE_ADMIN_JURUSAN)
        <div class="card-container-adm">
            <div class="card-item-adm">
                <h4>Siswa Jurusan</h4>
                <div class="detail-card">
                    <img src="img/nis-icon.png" alt="">
                    <h2>{{ $totalSiswa }} Siswa</h2>
                </div>
            </div>
            <div class="card-item-adm">
                <h4>Lokasi Prakerin</h4>
                <div class="detail-card">
                    <img src="img/lokasi-icon.png" alt="">
                    <h2>{{ $totalLokasiPrakerin }} Lokasi Prakerin</h2>
                </div>
            </div>
            <div class="header-filter-adm">
                <h1>Penetapan Prakerin</h1>
            </div>
            <div class="data-filter-adm">
                <div class="filter-header">
                    <h5>Rentang Tahun Ajaran</h5>
                </div>
                <form id="filterForm">
                    <label for="tahun_awal"><h5>Dari:</h5></label>
                    <select id="tahun_awal" name="tahun_awal" class="filter-value">
                        <option value="">Pilih</option>
                        @foreach ($semuaTahunAjaran as $tahun)
                            <option value="{{ $tahun->tahun_ajaran }}">
                                {{ $tahun->tahun_ajaran }}
                            </option>
                        @endforeach
                    </select>
                    <label for="tahun_akhir"><h5>Sampai:</h5></label>
                    <select id="tahun_akhir" name="tahun_akhir" class="filter-value">
                        <option value="">Pilih</option>
                        @foreach ($semuaTahunAjaran as $tahun)
                            <option value="{{ $tahun->tahun_ajaran }}">
                                {{ $tahun->tahun_ajaran }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="card-item-adm">
                <canvas id="chartPrakerin"
                    data-url="{{ route('dashboard.chart-data') }}"
                    data-initial-labels="{{ json_encode($chartLabels ?? []) }}"
                    data-initial-values="{{ json_encode($chartData ?? []) }}">
                </canvas>
            </div>
            <div class="card-item-adm">
                <canvas id="chartDudi"
                    data-url="{{ route('dashboard.chart-data') }}"
                    data-initial-labels="{{ json_encode($chartLabelsDudi ?? []) }}"
                    data-initial-values="{{ json_encode($chartDataDudi ?? []) }}">
                </canvas>
            </div>
        </div>

    {{-- Dashboard Admin Utama --}}
    @elseif ($role === User::ROLE_ADMIN_UTAMA)
        <div class="card-container">
            <div class="card-item">
                <h4>Pengguna</h4>
                <div class="detail-card">
                    <img src="img/nis-icon.png" alt="">
                    <h2>{{ $totalUsers }} Pengguna</h2>
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
