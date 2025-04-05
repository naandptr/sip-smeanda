@php 
    $page_name = 'admin_utama/tahun_ajar'; 
@endphp

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
            <button class="btn-open" id="tambahTahunAjar" data-bs-toggle="modal" data-bs-target="#modalTahunAjar">
                + Tahun Ajaran
            </button>
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
                        @foreach($tahunAjar as $index => $tahun)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $tahun->tahun_ajaran }}</td>
                            <td>{{ date('d/m/Y', strtotime($tahun->periode_mulai)) }}</td>
                            <td>{{ date('d/m/Y', strtotime($tahun->periode_selesai)) }}</td>
                            <td>
                                <div class="status-kegiatan {{ strtolower($tahun->status) }}">
                                    {{ $tahun->status }}
                                </div>
                            </td>
                            <td class="data-aksi">
                                <!-- Toggle Status -->
                                <div class="toggle-switch {{ $tahun->status == 'Aktif' ? 'active' : '' }}" data-id="{{ $tahun->id }}">
                                    <div class="toggle-slider"></div>
                                </div>

                                
                                <!-- Tombol Edit -->
                                <button class="btn-icon editTahunAjar" data-id="{{ $tahun->id }}">
                                    <img src="{{ asset('img/edit-icon.png') }}" alt="Edit">
                                </button>
                                
                                <!-- Tombol Hapus -->
                                <button class="btn-icon deleteTahunAjar" data-id="{{ $tahun->id }}">
                                    <img src="{{ asset('img/hapus-icon.png') }}" alt="Hapus">
                                </button>
                            </td>
                        </tr>
                        @endforeach
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
</div>

@endsection

{{-- @push('page_scripts')
    <script src="{{ asset('js/admin_utama/tahun_ajar.js') }}"></script>
@endpush --}}