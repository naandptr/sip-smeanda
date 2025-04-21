@php 
    $page_name = 'admin_utama/tahun_ajar'; 
@endphp

@extends('layouts.app')

@section('title', 'Tahun Ajaran')

@section('content')
<div class="data-container">
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
                        @foreach($dataTahunAjar as $index => $tahunAjar)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $tahunAjar->tahun_ajaran }}</td>
                            <td>{{ date('d/m/Y', strtotime($tahunAjar->periode_mulai)) }}</td>
                            <td>{{ date('d/m/Y', strtotime($tahunAjar->periode_selesai)) }}</td>
                            <td>
                                <div class="status-kegiatan {{ strtolower($tahunAjar->status) }}">
                                    {{ $tahunAjar->status }}
                                </div>
                            </td>
                            <td class="data-aksi">
                                <div class="toggle-switch {{ $tahunAjar->status == 'Aktif' ? 'active' : '' }}" data-id="{{ $tahunAjar->id }}">
                                    <div class="toggle-slider"></div>
                                </div>

                                <button class="btn-icon editTahunAjar" data-id="{{ $tahunAjar->id }}">
                                    <img src="{{ asset('img/edit-icon.png') }}" alt="Edit">
                                </button>
                                
                                <button class="btn-icon deleteTahunAjar" data-id="{{ $tahunAjar->id }}">
                                    <img src="{{ asset('img/hapus-icon.png') }}" alt="Hapus">
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="data-footer">
                            <td colspan="6">
                                <div class="pagination custom-pagination">
                                    @if ($dataTahunAjar->onFirstPage())
                                        <span class="prev disabled">Previous</span>
                                    @else
                                        <a href="{{ $dataTahunAjar->previousPageUrl() }}" class="prev">Previous</a>
                                    @endif
                    
                                    <span class="page-info">
                                        {{ $dataTahunAjar->firstItem() }}-{{ $dataTahunAjar->lastItem() }} of {{ $dataTahunAjar->total() }}
                                    </span>
                    
                                    @if ($dataTahunAjar->hasMorePages())
                                        <a href="{{ $dataTahunAjar->nextPageUrl() }}" class="next">Next</a>
                                    @else
                                        <span class="next disabled">Next</span>
                                    @endif
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
