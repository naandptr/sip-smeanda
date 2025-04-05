@extends('layouts.app')

@section('title', 'Penilaian')

@section('content')
<div class="data-container">
    <!-- Header -->
    <div class="header">
        <h1>Penilaian</h1>
    </div>

    <div class="data-section">
        <form action="">
            <div class="nilai-form-container">
                <div class="nilai-form-header">
                    <div class="nilai-header-info">
                        <div class="nilai-header-label">
                            <label for="namaSiswaNilai">Nama Peserta Didik</label>
                        </div>
                        <div class="nilai-header-value">
                            <select name="namaSiswaNilai" id="namaSiswaNilai">
                                <option value="">Arslan Allen</option>
                                <option value="">Dudi Dudidam</option>
                            </select>
                        </div>
                    </div>
                    <div class="nilai-header-info">
                        <div class="nilai-header-label">
                            NIS
                        </div>
                        <div class="nilai-header-value">
                        -
                        </div>
                    </div>
                    <div class="nilai-header-info">
                        <div class="nilai-header-label">
                            Kelas
                        </div>
                        <div class="nilai-header-value">
                        -
                        </div>
                    </div>
                    <div class="nilai-header-info">
                        <div class="nilai-header-label">
                            Program Keahlian
                        </div>
                        <div class="nilai-header-value">
                        -
                        </div>
                    </div>
                    <div class="nilai-header-info">
                        <div class="nilai-header-label">
                            Konsentrasi Keahlian
                        </div>
                        <div class="nilai-header-value">
                        -
                        </div>
                    </div>
                    <div class="nilai-header-info">
                        <div class="nilai-header-label">
                            Tempat PKL
                        </div>
                        <div class="nilai-header-value">
                        -
                        </div>
                    </div>
                    <div class="nilai-header-info">
                        <div class="nilai-header-label">
                            Tanggal PKL
                        </div>
                        <div class="nilai-header-value">
                        -
                        </div>
                    </div>
                    <div class="nilai-header-info">
                        <div class="nilai-header-label">
                            <label for="namaInstrukturNilai">Nama Instruktur</label>
                        </div>
                        <div class="nilai-header-value">
                            <input type="text" name="namaInstruktuNilai" id="namaInstrukturNilai">
                        </div>
                    </div>
                    <div class="nilai-header-info">
                        <div class="nilai-header-label">
                            Nama Pembimbing
                        </div>
                        <div class="nilai-header-value">
                        -
                        </div>
                    </div>
                    
                </div>

                <div class="nilai-form-body">
                    <div class="nilai-form-section">
                        <div class="data-action">
                            <button type="button" class="btn-open btn-open-nilai" data-bs-toggle="modal" data-bs-target="#modalNilai">+ Nilai</button>
                        </div>
                        <div class="data-content">
                            <div class="table-wrapper">
                                <table class="data-table">
                                    <thead class="data-header">
                                        <tr>
                                            <th>NO</th>
                                            <th>TUJUAN PEMBELAJARAN</th>
                                            <th>SKOR</th>
                                            <th>DESKRIPSI</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody class="data-body">
                                        <tr>
                                            <td>1</td>
                                            <td>Mampu melakukan analisis usaha secara mandiri</td>
                                            <td>100</td>
                                            <td>Siswa mampu menerapkan...</td>
                                            <td class="data-aksi">
                                                <!-- Tombol Hapus -->
                                                <button class="btn-icon btn-hapus-nilai">
                                                    <img src="{{ asset('img/hapus-icon.png') }}" alt="Hapus">
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>             
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="nilai-form-section catatan-nilai">
                        <label for="">Catatan:</label>
                        <textarea name="" id="" cols="30" rows="10"></textarea>
                    </div>

                    <div class="nilai-form-section">
                        <div class="data-content">
                            <table class="data-table">
                                <thead class="data-header">
                                    <tr>
                                        <th colspan="2">KETIDAKHADIRAN</th>
                                    </tr>
                                </thead>
                                <tbody class="data-body">
                                    <tr>
                                        <td>Sakit</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Ijin</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Tanpa Keterangan</td>
                                        <td>-</td>
                                    </tr>
                                </tbody>             
                            </table>
                        </div>
                    </div>
                </div>
                <div class="nilai-form-footer">
                    <button type="button" class="btn-cancel">Cancel</button>
                    <button type="submit" class="btn-submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
<x-modal_nilai></x-modal_nilai>