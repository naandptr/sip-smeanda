@extends('layouts.app')

@section('title', 'Data Lokasi')

@section('content')
<div class="data-container">
    <!-- Header -->
    <div class="header">
        <h1>Data Lokasi</h1>
    </div>

    <div class="data-section">
        <div class="data-action">
            <button class="btn-open btn-open-lokasi" data-bs-toggle="modal" data-bs-target="#modalLokasi">Tambah Lokasi</button>
            <x-modal_lokasi></x-modal_lokasi>
        </div>
        <div class="data-content">
            <div class="table-wrapper">
                <table class="data-table">
                    <thead class="data-header">
                        <tr>
                            <th>NO</th>
                            <th>NAMA DUDI</th>
                            <th>ALAMAT</th>
                            <th>BIDANG USAHA</th>
                            <th>KUOTA SISWA</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="data-body">
                        <tr>
                            <td>1</td>
                            <td>PT. ABCD Animax Jaya</td>
                            <td>Sipin, Jambi</td>
                            <td>Animator</td>
                            <td>5 Siswa</td>
                            <td class="btn-aksi">
                                <!-- Tombol Lihat -->
                                <button class="btn-open">
                                    Detail
                                </button>
                                <!-- Tombol Edit -->
                                <button class="btn-icon btn-open-lokasi">
                                    <img src="{{ asset('img/edit-icon.png') }}" alt="Edit">
                                </button>
                                <!-- Tombol Hapus -->
                                <button class="btn-icon btn-hapus-lokasi">
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
