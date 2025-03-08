@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
<div class="dashboard">
    <h1>Selamat Datang</h1>
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
                <img src="img/nis-icon.png" alt="">
                <h2>3 Lokasi Prakerin</h2>
            </div>
        </div>
    </div>
</div>
@endsection
