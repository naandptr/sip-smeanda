@extends('layouts.app')

@section('title', 'Tahun Ajaran')

@section('content')
<div class="data-container">
    <!-- Header -->
    <div class="header">
        <h1>Tahun Ajaran</h1>
    </div>

    <div class="data-section">
        <div class="data-action">
            <button class="btn-open btn-open-tahunajar" data-bs-toggle="modal" data-bs-target="#modalTahunAjar">+ Tahun Ajaran</button>
            <x-modal_tahun_ajar></x-modal_tahun_ajar>
        </div>
        <div class="data-content">
            <div class="table-wrapper">
                <table class="data-table">
                    <thead class="data-header">
                        <tr>
                            <th>NO</th>
                            <th>TAHUN AJARAN</th>
                            <th>PERIODE MULAI</th>
                            <th>PERIODE SELESAI</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="data-body">
                        <tr>
                            <td>1</td>
                            <td>2024/2025</td>
                            <td>01/01/2025</td>
                            <td>30/06/2025</td>
                            <td><div id="statusTA" class="status-kegiatan nonaktif">Nonaktif</div></td>
                            <td class="btn-aksi">
                                <!-- Tombol Edit -->
                                <div id="toggleStatus" class="toggle-switch">
                                    <div class="toggle-slider"></div>
                                </div>
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
