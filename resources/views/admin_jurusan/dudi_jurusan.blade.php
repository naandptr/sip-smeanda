@php 
    $page_name = 'admin_jurusan/dudi_jurusan'; 
@endphp

@extends('layouts.app')

@section('title', 'Penetapan DUDI')

@section('content')
<div class="data-container">
    <!-- Header -->
    <div class="header">
        <h1>Penetapan DUDI</h1>
    </div>

    <div class="data-section">
        <div class="data-action">
            <button class="btn-open" id="tambahDudiJurusan" data-bs-toggle="modal" data-bs-target="#modalDudiJurusan">+ Penetapan</button>
            <x-modal_dudi_jurusan :dudi="$dudi" :pembimbing="$pembimbing" :tahunAjar="$tahunAjar" />
        </div>
        <div class="data-content">
            <div class="table-wrapper">
                <table class="data-table">
                    <thead class="data-header">
                        <tr>
                            <th>NO</th>
                            <th>NAMA PEMBIMBING</th>
                            <th>PENETAPAN DUDI</th>
                            <th>TAHUN AJARAN</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="data-body">
                        @foreach($dataDudiJurusan as $index => $dudiJurusan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $dudiJurusan->pembimbing->nama }}</td>
                            <td>{{ $dudiJurusan->dudi->nama_dudi }}</td>
                            <td>{{ $dudiJurusan->tahunAjar->tahun_ajaran }}</td>
                            <td class="data-aksi">
                                <button class="btn-icon editDudiJurusan" data-id="{{ $dudiJurusan->id }}">
                                    <img src="{{ asset('img/edit-icon.png') }}" alt="Edit">
                                </button>
                                <button class="btn-icon deleteDudiJurusan" data-id="{{ $dudiJurusan->id }}">
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
                                    @if ($dataDudiJurusan->onFirstPage())
                                        <span class="prev disabled">Sebelumnya</span>
                                    @else
                                        <a href="{{ $dataDudiJurusan->previousPageUrl() }}" class="prev">Sebelumnya</a>
                                    @endif
                    
                                    <span class="page-info">
                                        {{ $dataDudiJurusan->firstItem() }}-{{ $dataDudiJurusan->lastItem() }} dari {{ $dataDudiJurusan->total() }}
                                    </span>
                    
                                    @if ($dataDudiJurusan->hasMorePages())
                                        <a href="{{ $dataDudiJurusan->nextPageUrl() }}" class="next">Selanjutnya</a>
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