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
        <form class="form-dokumen" id="formCV" method="get" enctype="multipart/form-data">
            <!-- Input File -->
            <div class="document-input">
                <h4>File</h4>
                <div class="document-upload">
                    <input type="file" name="cv" id="cvInput" hidden>
                    <label for="cvInput" class="file-btn">Pilih file</label>
                    <p class="file-name" id="cvName">No file chosen</p>
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
        <form class="form-dokumen" id="formPorto" method="get" enctype="multipart/form-data">
            <!-- Input File -->
            <div class="document-input">
                <h4>File</h4>
                <div class="document-upload">
                    <input type="file" name="porto" id="portoInput" hidden>
                    <label for="portoInput" class="file-btn">Pilih file</label>
                    <p class="file-name" id="portoName">No file chosen</p>
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
        <form class="form-dokumen" id="formLaporan" method="get" enctype="multipart/form-data">
            <!-- Input File -->
            <div class="document-input">
                <h4>File</h4>
                <div class="document-upload">
                    <input type="file" name="laporan" id="laporanInput" hidden>
                    <label for="laporanInput" class="file-btn">Pilih file</label>
                    <p class="file-name" id="laporanName">No file chosen</p>
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
        <form class="form-dokumen" id="formSertifikat" method="get" enctype="multipart/form-data">
            <!-- Input File -->
            <div class="document-input">
                <h4>File</h4>
                <div class="document-upload">
                    <input type="file" name="sertifikat" id="sertifikatInput" hidden>
                    <label for="sertifikatInput" class="file-btn">Pilih file</label>
                    <p class="file-name" id="sertifikatName">No file chosen</p>
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
