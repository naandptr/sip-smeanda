@php 
    $page_name = 'admin_utama/lokasi'; 
@endphp

@extends('layouts.app')

@section('title', 'Data Lokasi')

@section('content')
<div class="data-container">
    <div class="header">
        <h1>Kelola Lokasi</h1>
    </div>

    <div class="data-section">
        <div class="data-action">
            <button class="btn-open" id="tambahLokasi" data-bs-toggle="modal" data-bs-target="#modalLokasi">+ Lokasi</button>
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
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="data-body">
                        @foreach($dataDudi as $index => $dudi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $dudi->nama_dudi }}</td>
                            <td>{{ $dudi->alamat }}</td>
                            <td>{{ $dudi->bidang_usaha }}</td>
                            <td class="data-aksi">
                                <button class="btn-icon" data-bs-toggle="modal" data-bs-target="#modalDetailLokasi-{{ $dudi->id }}">
                                    <img src="{{ asset('img/show-icon.png') }}" alt="Lihat">
                                </button>
                                <x-modal_detail_lokasi :dudi="$dudi" :modalId="'modalDetailLokasi-' . $dudi->id" />
                                <button class="btn-icon editLokasi" data-id="{{ $dudi->id }}">
                                    <img src="{{ asset('img/edit-icon.png') }}" alt="Edit">
                                </button>
                                <button class="btn-icon deleteLokasi" data-id="{{ $dudi->id }}">
                                    <img src="{{ asset('img/hapus-icon.png') }}" alt="Hapus">
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="data-footer">
                            <td colspan="5">
                                <div class="pagination custom-pagination">
                                    @if ($dataDudi->onFirstPage())
                                        <span class="prev disabled">Sebelumnya</span>
                                    @else
                                        <a href="{{ $dataDudi->previousPageUrl() }}" class="prev">Sebelumnya</a>
                                    @endif
                    
                                    <span class="page-info">
                                        {{ $dataDudi->firstItem() }}-{{ $dataDudi->lastItem() }} dari {{ $dataDudi->total() }}
                                    </span>
                    
                                    @if ($dataDudi->hasMorePages())
                                        <a href="{{ $dataDudi->nextPageUrl() }}" class="next">Selanjutnya</a>
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