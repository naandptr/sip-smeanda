@php 
    $page_name = 'admin_jurusan/dudi_jurusan'; 
@endphp

@extends('layouts.app')

@section('title', 'Penetapan DUDI')

@section('content')
<div class="data-container">
    <!-- Header -->
    <div class="header">
        <h1>Penetapan DUDI</h1>
    </div>

    <div class="data-section">
        <div class="data-action">
            <button class="btn-open" id="tambahDudiJurusan" data-bs-toggle="modal" data-bs-target="#modalDudiJurusan">Tambah Penetapan</button>
            <x-modal_dudi_jurusan :dudi="$dudi" :pembimbing="$pembimbing" :tahunAjar="$tahunAjar" />
        </div>
        <div class="data-content">
            <div class="table-wrapper">
                <table class="data-table">
                    <thead class="data-header">
                        <tr>
                            <th>NO</th>
                            <th>NAMA PEMBIMBING</th>
                            <th>PENETAPAN DUDI</th>
                            <th>TAHUN AJARAN</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="data-body">
                        <tr>
                            <td>1</td>
                            <td>Siti Menenun</td>
                            <td>PT. ABCD Animax Jaya</td>
                            <td>2024/2025</td>
                            <td class="data-aksi">
                                <!-- Tombol Edit -->
                                <button class="btn-icon" data-bs-toggle="modal" data-bs-target="#modalDudiJurusan">
                                    <img src="{{ asset('img/edit-icon.png') }}" alt="Edit">
                                </button>
                                <!-- Tombol Hapus -->
                                <button class="btn-icon">
                                    <img src="{{ asset('img/hapus-icon.png') }}" alt="Hapus">
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="data-footer">
                            <td colspan="5">
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
    <script src="{{ asset('js/admin_jurusan/dudi_jurusan.js') }}"></script>
@endpush
