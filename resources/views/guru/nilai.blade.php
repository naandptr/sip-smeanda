@php 
    $page_name = 'guru/nilai'; 
@endphp

@extends('layouts.app')

@section('title', 'Penilaian')

@section('content')
<div class="data-container">
    <div class="header">
        <h1>Penilaian</h1>
    </div>

    <div class="data-section">
        <div class="data-filter">
            <form method="GET" action="{{ route('guru.nilai') }}">
                <div class="filter-value">
                    <select name="tahun_ajaran">
                        <option value="">Pilih Tahun Ajaran</option>
                        @foreach ($dataTahunAjaran as $tahun)
                            <option value="{{ $tahun }}" {{ request('tahun_ajaran') == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-value">
                    <select name="status">
                        <option value="">Pilih Status</option>
                        <option value="belum_dimulai" {{ request('status') == 'belum_dimulai' ? 'selected' : '' }}>Belum Dimulai</option>
                        <option value="berlangsung" {{ request('status') == 'berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <button type="submit" class="btn-icon">
                    <img src="{{ asset('img/filter-icon.png') }}" alt="Filter">
                </button>
            </form>            
        </div>
        <div class="data-action">
            <a href="{{ route('nilai.form') }}"><button class="btn-open">+ Penilaian</button></a>
        </div>
        <div class="data-content">
            <div class="table-wrapper">
                <table class="data-table">
                    <thead class="data-header">
                        <tr>
                            <th>NIS</th>
                            <th>SISWA</th>
                            <th>KELAS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="data-body">
                        @foreach ($dataSiswa as $siswa)
                            @if ($siswa->penetapanPrakerin && $siswa->penetapanPrakerin->isNotEmpty())
                                @foreach ($siswa->penetapanPrakerin as $penetapan)
                                    @if ($penetapan->penilaian && $penetapan->penilaian->isNotEmpty())
                                        <tr>
                                            <td>{{ $siswa->nis }}</td>
                                            <td>{{ $siswa->nama }}</td>
                                            <td>{{ $siswa->kelas->nama_kelas }}</td>
                                            <td class="data-aksi">
                                                <a href="{{ route('nilai.download', $penetapan->penilaian->first()->id) }}">
                                                    <button class="btn-aksi">Unduh</button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="data-footer">
                            <td colspan="4">
                                <div class="pagination custom-pagination">
                                    @if ($dataSiswa->onFirstPage())
                                        <span class="prev disabled">Previous</span>
                                    @else
                                        <a href="{{ $dataSiswa->previousPageUrl() }}" class="prev">Previous</a>
                                    @endif
                    
                                    <span class="page-info">
                                        {{ $dataSiswa->firstItem() }}-{{ $dataSiswa->lastItem() }} of {{ $dataSiswa->total() }}
                                    </span>
                    
                                    @if ($dataSiswa->hasMorePages())
                                        <a href="{{ $dataSiswa->nextPageUrl() }}" class="next">Next</a>
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

