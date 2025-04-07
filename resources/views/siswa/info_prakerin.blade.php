@extends('layouts.app')

@section('title', 'Informasi Prakerin')

@section('content')
<div class="info">
    <div class="header">
        <h1>Informasi Prakerin</h1>
    </div>
    <div class="info-section">
        <div class="info-header">
            <h2>Periode Prakerin</h2>
        </div>
        <div class="info-content">
            <div class="info-item">
                <h4>Tanggal Mulai Prakerin</h4>
                <div class="info-value">
                    <h5>{{ \Carbon\Carbon::parse($penetapan->tanggal_mulai)->format('d/m/Y') ?? '-' }}</h5>
                </div>
            </div>
            <div class="info-item">
                <h4>Tanggal Selesai Prakerin</h4>
                <div class="info-value">
                    <h5>{{ \Carbon\Carbon::parse($penetapan->tanggal_selesai)->format('d/m/Y') ?? '-' }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="info-section">
        <div class="info-header">
            <h2>Lokasi Prakerin</h2>
        </div>
        <div class="info-content">
            <div class="info-item">
                <h4>Nama Perusahaan</h4>
                <div class="info-value">
                    <h5>{{ $penetapan->dudiJurusan->dudi->nama_dudi ?? '-' }}</h5>
                </div>
            </div>
            <div class="info-item">
                <h4>Alamat Perusahaan</h4>
                <div class="info-value">
                    <h5>{{ $penetapan->dudiJurusan->dudi->alamat ?? '-' }}</h5>
                </div>
            </div>
            <div class="info-item">
                <h4>Nomor Telepon</h4>
                <div class="info-value">
                    <h5>{{ $penetapan->dudiJurusan->dudi->telp ?? '-' }}</h5>
                </div>
            </div>
            <div class="info-item">
                <h4>Email</h4>
                <div class="info-value">
                    <h5>{{ $penetapan->dudiJurusan->dudi->email ?? '-' }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="info-section">
        <div class="info-header">
            <h2>Guru Pembimbing</h2>
        </div>
        <div class="info-content">
            <div class="info-item">
                <h4>Nama Guru Pembimbing</h4>
                <div class="info-value">
                    <h5>{{ $penetapan->dudiJurusan->pembimbing->nama ?? '-' }}</h5>
                </div>
            </div>
            <div class="info-item">
                <h4>Kontak Guru Pembimbing</h4>
                <div class="info-value">
                    <h5>{{ $penetapan->dudiJurusan->pembimbing->telp ?? '-' }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
