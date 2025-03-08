@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="dashboard">
    <h1>Selamat Datang</h1>
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
</div>
@endsection
