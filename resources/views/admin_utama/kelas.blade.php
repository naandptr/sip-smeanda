@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')
<div class="data-container">
    <!-- Header -->
    <div class="header">
        <h1>Data Kelas</h1>
    </div>

    <div class="data-section">
        <div class="data-action">
            <button class="btn-open btn-open-kelas" data-bs-toggle="modal" data-bs-target="#modalKelas">Tambah Kelas</button>
            <x-modal_kelas></x-modal_kelas>
        </div>
        <div class="data-content">
            <div class="table-wrapper">
                <table class="data-table">
                    <thead class="data-header">
                        <tr>
                            <th>NO</th>
                            <th>NAMA KELAS</th>
                            <th>JURUSAN</th>
                            <th>TAHUN AJARAN</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="data-body">
                        <tr>
                            <td>1</td>
                            <td>XII Animasi 1</td>
                            <td>Animasi</td>
                            <td>2024/2025</td>
                            <td class="btn-aksi">
                                <!-- Tombol Edit -->
                                <button class="btn-icon">
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
