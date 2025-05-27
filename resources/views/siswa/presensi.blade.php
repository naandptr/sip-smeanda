@php 
    $page_name = 'siswa/presensi'; 
@endphp

@extends('layouts.app')

@section('title', 'Presensi Harian')

@section('content')
<div class="presensi data-container">
    <div class="header">
        <h1>Presensi Harian</h1>
    </div>

    <div class="presensi-section data-section">
        <div class="presensi-action data-action">
            <button class="btn-open" id="tambahPresensi" data-bs-toggle="modal" data-bs-target="#modalPresensi">+ Presensi</button>
            <x-modal_presensi />
        </div>

        <div class="presensi-content data-content">
            <div class="table-wrapper">
                <table class="presensi-table data-table">
                    <thead class="presensi-header data-header">
                        <tr>
                            <th>NO</th>
                            <th>TANGGAL</th>
                            <th>JENIS PRESENSI</th>
                            <th>STATUS</th>
                            <th>KETERANGAN</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="presensi-body data-body">
                        @foreach ($dataPresensi as $presensi)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($presensi->tanggal)->format('d/m/Y') }}</td>
                            <td>{{ ucfirst($presensi->jenis_presensi) }}</td>
                            <td>{{ $presensi->status_kehadiran ?? '-' }}</td>
                            <td>{{ $presensi->keterangan ?? '-' }}</td>
                            <td class="data-aksi">
                                <button type="button" class="btn-icon show-detail-presensi"
                                    data-bs-toggle="modal" data-bs-target="#modalDetailPresensi"
                                    data-file-url="{{ asset('storage/' . $presensi->file) }}">
                                    <img src="{{ asset('img/show-icon.png') }}" alt="Detail">
                                </button>
                                <x-modal_detail_presensi />
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="presensi-footer data-footer">
                            <td colspan="6">
                                <div class="pagination custom-pagination">
                                    @if ($dataPresensi->onFirstPage())
                                        <span class="prev disabled">Sebelumnya</span>
                                    @else
                                        <a href="{{ $dataPresensi->previousPageUrl() }}" class="prev">Sebelumnya</a>
                                    @endif
                    
                                    <span class="page-info">
                                        {{ $dataPresensi->firstItem() }}-{{ $dataPresensi->lastItem() }} dari {{ $dataPresensi->total() }}
                                    </span>
                    
                                    @if ($dataPresensi->hasMorePages())
                                        <a href="{{ $dataPresensi->nextPageUrl() }}" class="next">Selanjutnya</a>
                                    @else
                                        <span class="next disabled">Selanjutnya</span>
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
