@php 
    $page_name = 'siswa/absen'; 
@endphp

@extends('layouts.app')

@section('title', 'Absensi Harian')

@section('content')
<div class="absen data-container">
    <div class="header">
        <h1>Absensi Harian</h1>
    </div>

    <div class="absen-section data-section">
        <div class="absen-action data-action">
            <button class="btn-open" id="tambahAbsen" data-bs-toggle="modal" data-bs-target="#modalAbsen">Buat Absen</button>
            <x-modal_absen></x-modal_absen>
        </div>

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
                        @foreach ($dataAbsen as $absen)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($absen->tanggal)->format('d/m/Y') }}</td>
                            <td>{{ ucfirst($absen->jenis_absen) }}</td>
                            <td>{{ $absen->status_kehadiran ?? '-' }}</td>
                            <td>{{ $absen->keterangan ?? '-' }}</td>
                            <td class="data-aksi">
                                <button type="button" class="btn-icon show-detail-absen"
                                    data-bs-toggle="modal" data-bs-target="#modalDetailAbsen"
                                    data-file-url="{{ Storage::url($absen->file) }}">
                                    <img src="{{ asset('img/show-icon.png') }}" alt="Detail">
                                </button>
                                <x-modal_detail_absen />
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="absen-footer data-footer">
                            <td colspan="6">
                                <div class="pagination custom-pagination">
                                    @if ($dataAbsen->onFirstPage())
                                        <span class="prev disabled">Previous</span>
                                    @else
                                        <a href="{{ $dataAbsen->previousPageUrl() }}" class="prev">Previous</a>
                                    @endif
                    
                                    <span class="page-info">
                                        {{ $dataAbsen->firstItem() }}-{{ $dataAbsen->lastItem() }} of {{ $dataAbsen->total() }}
                                    </span>
                    
                                    @if ($dataAbsen->hasMorePages())
                                        <a href="{{ $dataAbsen->nextPageUrl() }}" class="next">Next</a>
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
