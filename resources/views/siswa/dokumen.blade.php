@php 
    $page_name = 'siswa/dokumen'; 
@endphp

@extends('layouts.app')

@section('title', 'Dokumen Prakerin')

@section('content')
<div class="document">
    <div class="header">
        <h1>Dokumen Prakerin</h1>
    </div>
    <div class="document-section">
        <div class="document-title">
            <h2>Curriculum Vitae</h2>
        </div>
        <form action="{{ route('dokumen.upload', 'CV') }}" data-jenis="cv" class="form-dokumen" id="formCV" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Input File -->
            <div class="document-input">
                <h4>File</h4>
                <div class="document-upload">
                    <input type="file" name="dokumen" id="cvInput" hidden>
                    <label for="cvInput" class="file-btn">Pilih file</label>
                    <p class="file-name" id="cvName">
                        @if(isset($dokumen['CV']))
                            <a href="{{ route('dokumen.download', $dokumen['CV']->id) }}">
                                {{ basename($dokumen['CV']->file) }}
                            </a>
                        @else
                            No file chosen
                        @endif
                    </p>
                </div>             
            </div>

            <!-- Tombol Submit -->
            <div class="document-action">
                <button type="submit" class="btn-submit" id="cvSubmit">Submit</button>
            </div>
        </form>
    </div>

    <div class="document-section">
        <div class="document-title">
            <h2>Portofolio</h2>
        </div>
        <form action="{{ route('dokumen.upload', 'Portofolio') }}" data-jenis="portofolio" class="form-dokumen" id="formPorto" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Input File -->
            <div class="document-input">
                <h4>File</h4>
                <div class="document-upload">
                    <input type="file" name="dokumen" id="portofolioInput" hidden>
                    <label for="portofolioInput" class="file-btn">Pilih file</label>
                    <p class="file-name" id="portofolioName">
                        @if(isset($dokumen['Portofolio']))
                            <a href="{{ route('dokumen.download', $dokumen['Portofolio']->id) }}">
                                {{ basename($dokumen['Portofolio']->file) }}
                            </a>
                        @else
                            No file chosen
                        @endif
                    </p>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="document-action">
                <button type="submit" class="btn-submit" id="portoSubmit">Submit</button>
            </div>
        </form>
    </div>

    <div class="document-section">
        <div class="document-title">
            <h2>Laporan Prakerin</h2>
        </div>
        <form action="{{ route('dokumen.upload', 'Laporan') }}" data-jenis="laporan" class="form-dokumen" id="formLaporan" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Input File -->
            <div class="document-input">
                <h4>File</h4>
                <div class="document-upload">
                    <input type="file" name="dokumen" id="laporanInput" hidden>
                    <label for="laporanInput" class="file-btn">Pilih file</label>
                    <p class="file-name" id="laporanName">
                        @if(isset($dokumen['Laporan']))
                            <a href="{{ route('dokumen.download', $dokumen['Laporan']->id) }}">
                                {{ basename($dokumen['Laporan']->file) }}
                            </a>
                        @else
                            No file chosen
                        @endif
                    </p>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="document-action">
                <button type="submit" class="btn-submit" id="laporanSubmit">Submit</button>
            </div>
        </form>
    </div>

    <div class="document-section">
        <div class="document-title">
            <h2>Sertifikat Magang</h2>
        </div>
        <form action="{{ route('dokumen.upload', 'Sertifikat') }}" data-jenis="sertifikat" class="form-dokumen" id="formSertifikat" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Input File -->
            <div class="document-input">
                <h4>File</h4>
                <div class="document-upload">
                    <input type="file" name="dokumen" id="sertifikatInput" hidden>
                    <label for="sertifikatInput" class="file-btn">Pilih file</label>
                    <p class="file-name" id="sertifikatName">
                        @if(isset($dokumen['Sertifikat']))
                            <a href="{{ route('dokumen.download', $dokumen['Sertifikat']->id) }}">
                                {{ basename($dokumen['Sertifikat']->file) }}
                            </a>
                        @else
                            No file chosen
                        @endif
                    </p>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="document-action">
                <button type="submit" class="btn-submit" id="sertifikatSubmit">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection

