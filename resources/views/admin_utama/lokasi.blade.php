@php 
    $page_name = 'admin_utama/lokasi'; 
@endphp

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
            <button class="btn-open" id="tambahLokasi" data-bs-toggle="modal" data-bs-target="#modalLokasi">Tambah Lokasi</button>
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
                        @foreach($dudi as $index => $data)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $data->nama_dudi }}</td>
                            <td>{{ $data->alamat }}</td>
                            <td>{{ $data->bidang_usaha }}</td>
                            <td class="data-aksi">
                                <!-- Tombol Lihat -->
                                <button class="btn-icon" data-bs-toggle="modal" data-bs-target="#modalDetailLokasi-{{ $data->id }}">
                                    <img src="{{ asset('img/show-icon.png') }}" alt="Lihat">
                                </button>
        
                                <x-modal_detail_lokasi :dudi="$data" :modalId="'modalDetailLokasi-' . $data->id" />
                                <!-- Tombol Edit -->
                                <button class="btn-icon editLokasi" data-id="{{ $data->id }}">
                                    <img src="{{ asset('img/edit-icon.png') }}" alt="Edit">
                                </button>
                                <!-- Tombol Hapus -->
                                <button class="btn-icon deleteLokasi" data-id="{{ $data->id }}">
                                    <img src="{{ asset('img/hapus-icon.png') }}" alt="Hapus">
                                </button>
                            </td>
                        </tr>
                        @endforeach
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