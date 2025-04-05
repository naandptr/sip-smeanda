@extends('layouts.app')

@section('title', 'Jurnal Kegiatan Siswa')

@section('content')
<div class="data-container">
    <!-- Header -->
    <div class="header">
        <h1>Jurnal Kegiatan Siswa</h1>
    </div>

    <div class="data-section">
        <!-- Tabel Jurnal-->
        <div class="data-content">
            <div class="table-wrapper"></div>
            <table class="data-table">
                <thead class="data-header">
                    <tr>
                        <th>NIS</th>
                        <th>SISWA</th>
                        <th>KELAS</th>
                        <th>TANGGAL</th>
                        <th>STATUS</th>
                        <th style="width: 250px;">AKSI</th>
                    </tr>
                </thead>
                <tbody class="data-body">
                    <tr>
                        <td>0031652858</td>
                        <td>Arslan Allen</td>
                        <td>XII Animasi I</td>
                        <td>20/08/2025</td>
                        <td><div class="status-badge">MENUNGGU</div></td>
                        <td class="data-aksi">
                            <!-- Tombol Lihat -->
                            <button type="button" class="btn-icon btn-open-jurnal" data-bs-toggle="modal" data-bs-target="#modalDetailJurnal">
                                <img src="{{ asset('img/show-icon.png') }}" alt="Lihat">
                            </button>
                            <x-modal_detail_jurnal></x-modal_detail_jurnal>

                            <!-- Tombol Validasi -->
                            <button type="button" class="btn-aksi" id="btnValidasi" data-bs-toggle="modal" data-bs-target="#modalValidasiJurnal">Validasi
                            </button>
                            <x-modal_validasi></x-modal_validasi>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="data-footer">
                        <td colspan="6">
                            <div class="pagination">
                                <span class="prev">Previous</span>
                                <span class="page-info">1-3 of 3</span>
                                <span class="next">Next</span>
                            </div>
                        </td>
                    </tr>
                </tfoot>                
            </table>
        </div>
    </div>
</div>
@endsection
