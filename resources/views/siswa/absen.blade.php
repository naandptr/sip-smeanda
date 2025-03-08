@extends('layouts.app')

@section('title', 'Absensi Harian')

@section('content')
<div class="absen data-container">
    <!-- Header -->
    <div class="header">
        <h1>Absensi Harian</h1>
    </div>

    <div class="absen-section data-section">
        <!-- Tombol Buat Absen -->
        <div class="absen-action data-action">
            <button class="btn-open btn-open-absen" data-bs-toggle="modal" data-bs-target="#modalAbsen">Buat Absen</button>
            <x-modal_absen></x-modal_absen>
        </div>

        <!-- Tabel Absensi -->
        <div class="absen-content data-content">
            <div class="table-wrapper">
                <table class="absen-table data-table">
                    <thead class="absen-header data-header">
                        <tr>
                            <th>ID</th>
                            <th>TANGGAL</th>
                            <th>JENIS ABSEN</th>
                            <th>STATUS</th>
                            <th>KETERANGAN</th>
                            <th>FOTO</th>
                        </tr>
                    </thead>
                    <tbody class="absen-body data-body">
                        <tr>
                            <td>1</td>
                            <td>13/02/2025</td>
                            <td>Absen Datang</td>
                            <td>Hadir</td>
                            <td>-</td>
                            <td class="btn-aksi"><img src="{{ asset('img/show-icon.png') }}" alt=""></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="absen-footer data-footer">
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
