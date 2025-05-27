@php 
    $page_name = 'admin_utama/kelas'; 
@endphp

@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')
<div class="data-container">
    <div class="header">
        <h1>Kelola Kelas</h1>
    </div>

    <div class="data-section">
        <div class="data-filter">
            <form method="GET" action="{{ route('admin.kelas') }}">
                <div class="filter-value">
                    <select name="tahun_ajaran">
                        <option value="">Pilih Tahun Ajaran</option>
                        @foreach ($tahunAjar as $tahun)
                            <option value="{{ $tahun->tahun_ajaran }}" {{ request('tahun_ajaran', $tahunAjar->firstWhere('status', 'aktif')->tahun_ajaran ?? '') == $tahun->tahun_ajaran ? 'selected' : '' }}>
                                {{ $tahun->tahun_ajaran }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-icon">
                    <img src="{{ asset('img/filter-icon.png') }}" alt="Filter">
                </button>
            </form>            
        </div>
        <div class="data-action">
            <button class="btn-open" id="tambahKelas" data-bs-toggle="modal" data-bs-target="#modalKelas">+ Kelas</button>
            <x-modal_kelas :jurusan="$jurusan" :tahunAjar="$tahunAjar" :tahunAjarAktif="$tahunAjarAktif" />
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
                                        <span class="prev disabled">Sebelumnya</span>
                                    @else
                                        <a href="{{ $dataKelas->previousPageUrl() }}" class="prev">Sebelumnya</a>
                                    @endif
                    
                                    <span class="page-info">
                                        {{ $dataKelas->firstItem() }}-{{ $dataKelas->lastItem() }} dari {{ $dataKelas->total() }}
                                    </span>
                    
                                    @if ($dataKelas->hasMorePages())
                                        <a href="{{ $dataKelas->nextPageUrl() }}" class="next">Selanjutnya</a>
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
