@php 
    $page_name = 'siswa/jurnal'; 
@endphp

@extends('layouts.app')

@section('title', 'Jurnal Kegiatan')

@section('content')
<div class="jurnal data-container">
    <!-- Header -->
    <div class="header">
        <h1>Jurnal Kegiatan</h1>
    </div>

    <div class="jurnal-section data-section">
        <!-- Tombol Buat Jurnal -->
        <div class="jurnal-action data-action">
            <button type="button" class="btn-open" id="tambahJurnal" data-bs-toggle="modal" data-bs-target="#modalJurnal">Buat Jurnal</button>
            <x-modal_jurnal></x-modal_jurnal>
        </div>

        <!-- Tabel Buat Absen-->
        <div class="jurnal-content data-content">
            <div class="table-wrapper">
                <table class="jurnal-table data-table">
                    <thead class="jurnal-header data-header">
                        <tr>
                            <th>ID</th>
                            <th>TANGGAL</th>
                            <th>DESKRIPSI</th>
                            <th>STATUS</th>
                            <th>CATATAN</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="jurnal-body data-body">
                        <tr>
                            <td>1</td>
                            <td>13/02/2025</td>
                            <td>Skibidi</td>
                            <td><div class="status-badge">MENUNGGU</div></td>
                            <td>-</td>
                            <td class="data-aksi">
                                <!-- Tombol Lihat -->
                                <button class="btn-icon" data-bs-toggle="modal" data-bs-target="#modalDetailJurnal">
                                    <img src="{{ asset('img/show-icon.png') }}" alt="Lihat">
                                </button>
                                <x-modal_detail_jurnal></x-modal_detail_jurnal>

                                <!-- Tombol Edit -->
                                <button class="btn-icon btn-open-jurnal" data-mode="edit"
                                    data-id="1" data-tanggal="13/02/2025" data-deskripsi="Skibidi">
                                    <img src="{{ asset('img/edit-icon.png') }}" alt="Edit">
                                </button>

                                <!-- Tombol Hapus -->
                                <button class="btn-icon btn-hapus-jurnal" data-id="1">
                                    <img src="{{ asset('img/hapus-icon.png') }}" alt="Hapus">
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="jurnal-footer data-footer">
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
</div>
@endsection

@push('page_scripts')
    <script src="{{ asset('js/siswa/jurnal.js') }}"></script>
@endpush
