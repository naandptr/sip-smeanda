@extends('layouts.app')

@section('title', 'Data User')

@section('content')
<div class="data-container">
    <!-- Header -->
    <div class="header">
        <h1>Data User</h1>
    </div>

    <div class="data-section">
        <div class="data-action">
            <button class="btn-open btn-open-user" data-bs-toggle="modal" data-bs-target="#modalUser">Tambah User</button>
            <x-modal_user></x-modal_user>
        </div>
        <div class="data-content">
            <div class="table-wrapper">
                <table class="data-table">
                    <thead class="data-header">
                        <tr>
                            <th>NO</th>
                            <th>NAMA PENGGUNA</th>
                            <th>ROLE</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="data-body">
                        <tr>
                            <td>1</td>
                            <td>Arslan Allen</td>
                            <td>Siswa</td>
                            <td>Aktif</td>
                            <td class="btn-aksi">
                                <!-- Tombol Lihat -->
                                <button class="btn-icon" data-bs-toggle="modal" data-bs-target="#modalDetailUser">
                                    <img src="{{ asset('img/show-icon.png') }}" alt="Lihat">
                                </button>
                                <x-modal_detail_user></x-modal_detail_user>

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
