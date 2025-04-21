@php 
    $page_name = 'admin_utama/kelas'; 
@endphp

@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')
<div class="data-container">
    <div class="header">
        <h1>Data Kelas</h1>
    </div>

    <div class="data-section">
        <div class="data-action">
            <button class="btn-open" id="tambahKelas" data-bs-toggle="modal" data-bs-target="#modalKelas">Tambah Kelas</button>
            <x-modal_kelas :jurusan="$jurusan" :tahunAjar="$tahunAjar" />
        </div>
        <div class="data-content">
            <div class="table-wrapper">
                <table class="data-table">
                    <thead class="data-header">
                        <tr>
                            <th>NO</th>
                            <th>NAMA KELAS</th>
                            <th>JURUSAN</th>
                            <th>TAHUN AJARAN</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="data-body">
                        @foreach($dataKelas as $index => $kelas)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $kelas->nama_kelas }}</td>
                            <td>{{ $kelas->jurusan->nama_jurusan }}</td>
                            <td>{{ $kelas->tahunAjar->tahun_ajaran }}</td>
                            <td class="data-aksi">
                                <button class="btn-icon editKelas" data-id="{{ $kelas->id }}">
                                    <img src="{{ asset('img/edit-icon.png') }}" alt="Edit">
                                </button>
                                <button class="btn-icon deleteKelas" data-id="{{ $kelas->id }}">
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
                                    @if ($dataKelas->onFirstPage())
                                        <span class="prev disabled">Previous</span>
                                    @else
                                        <a href="{{ $dataKelas->previousPageUrl() }}" class="prev">Previous</a>
                                    @endif
                    
                                    <span class="page-info">
                                        {{ $dataKelas->firstItem() }}-{{ $dataKelas->lastItem() }} of {{ $dataKelas->total() }}
                                    </span>
                    
                                    @if ($dataKelas->hasMorePages())
                                        <a href="{{ $dataKelas->nextPageUrl() }}" class="next">Next</a>
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
