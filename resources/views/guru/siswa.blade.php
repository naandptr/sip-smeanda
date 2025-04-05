@extends('layouts.app')

@section('title', 'Siswa Bimbingan')

@section('content')
<div class="data-container">
    <!-- Header -->
    <div class="header">
        <h1>Siswa Bimbingan</h1>
    </div>

    <div class="data-section">
        <!-- Tabel Buat Absen-->
        <div class="data-content">
            <table class="data-table">
                <thead class="data-header">
                    <tr>
                        <th>NIS</th>
                        <th>SISWA</th>
                        <th>KELAS</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody class="data-body">
                    <tr>
                        <td>0031652858</td>
                        <td>Arslan Allen</td>
                        <td>XII Animasi I</td>
                        <td><div class="status-badge">SELESAI</div></td>
                        <td class="data-aksi">
                            <!-- Tombol Lihat -->
                            <button type="button" class="btn-icon btn-open-siswa" data-bs-toggle="modal" data-bs-target="#modalDetailSiswa">
                                <img src="{{ asset('img/show-icon.png') }}" alt="Lihat">
                            </button>
                            <x-modal_detail_siswa></x-modal_detail_siswa>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="siswa-footer">
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
@endsection
