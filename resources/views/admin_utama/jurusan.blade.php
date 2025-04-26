@php 
    $page_name = 'admin_utama/jurusan'; 
@endphp

@extends('layouts.app')

@section('title', 'Data Jurusan')

@section('content')
<div class="data-container">
    <div class="header">
        <h1>Data Jurusan</h1>
    </div>

    <div class="data-section">
        <div class="data-filter">
            <form method="GET" action="{{ route('admin.jurusan') }}">
                <div class="filter-value">
                    <select name="status">
                        <option value="">Pilih Status</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <button type="submit" class="btn-icon">
                    <img src="{{ asset('img/filter-icon.png') }}" alt="Filter">
                </button>
            </form>            
        </div>
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
                        @foreach($dataJurusan as $index => $jurusan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $jurusan->kode_jurusan }}</td>
                            <td>{{ $jurusan->nama_jurusan }}</td>
                            <td>{{ $jurusan->status }}</td>
                            <td class="data-aksi">
                                <button class="btn-icon editJurusan" data-id="{{ $jurusan->id }}">
                                    <img src="{{ asset('img/edit-icon.png') }}" alt="Edit">
                                </button>
                                <button class="btn-icon deleteJurusan" data-id="{{ $jurusan->id }}">
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
                                    @if ($dataJurusan->onFirstPage())
                                        <span class="prev disabled">Previous</span>
                                    @else
                                        <a href="{{ $dataJurusan->previousPageUrl() }}" class="prev">Previous</a>
                                    @endif
                    
                                    <span class="page-info">
                                        {{ $dataJurusan->firstItem() }}-{{ $dataJurusan->lastItem() }} of {{ $dataJurusan->total() }}
                                    </span>
                    
                                    @if ($dataJurusan->hasMorePages())
                                        <a href="{{ $dataJurusan->nextPageUrl() }}" class="next">Next</a>
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


