@php 
    $page_name = 'admin_utama/jurusan'; 
@endphp

@extends('layouts.app')

@section('title', 'Data Jurusan')

@section('content')
<div class="data-container">
    <!-- Header -->
    <div class="header">
        <h1>Data Jurusan</h1>
    </div>

    <div class="data-section">
        <div class="data-action">
            <button class="btn-open" id="tambahJurusan" data-bs-toggle="modal" data-bs-target="#modalJurusan">Tambah Jurusan</button>
            <x-modal_jurusan></x-modal_jurusan>
        </div>
        <div class="data-content">
            <div class="table-wrapper">
                <table class="data-table">
                    <thead class="data-header">
                        <tr>
                            <th>NO</th>
                            <th>KODE JURUSAN</th>
                            <th>JURUSAN</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="data-body">
                        @foreach($jurusan as $index => $data)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $data->kode_jurusan }}</td>
                            <td>{{ $data->nama_jurusan }}</td>
                            <td>{{ $data->status }}</td>
                            <td class="data-aksi">
                                <!-- Tombol Edit -->
                                <button class="btn-icon editJurusan" data-id="{{ $data->id }}">
                                    <img src="{{ asset('img/edit-icon.png') }}" alt="Edit">
                                </button>
                                <!-- Tombol Hapus -->
                                <button class="btn-icon deleteJurusan" data-id="{{ $data->id }}">
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


