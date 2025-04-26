@extends('layouts.app')

@section('title', 'Jurnal Kegiatan Siswa')

@section('content')
<div class="data-container">
    <div class="header">
        <h1>Jurnal Kegiatan Siswa</h1>
    </div>

    <div class="data-section">
        <div class="data-filter">
            <form method="GET" action="{{ route('guru.jurnal') }}">
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
        <div class="data-content">
            <div class="table-wrapper"></div>
            <table class="data-table">
                <thead class="data-header">
                    <tr>
                        <th>NIS</th>
                        <th>SISWA</th>
                        <th>KELAS</th>
                        <th>CAPAIAN</th>
                        <th style="width: 250px;">AKSI</th>
                    </tr>
                </thead>
                <tbody class="data-body">
                    @foreach ($dataSiswa as $siswa)
                    <tr>
                        <td>{{ $siswa['siswa']->nis }}</td>
                        <td>{{ $siswa['siswa']->nama }}</td>
                        <td>{{ $siswa['kelas'] }}</td>
                        <td>{{ $siswa['jurnal_validasi'] }}/{{ $siswa['jurnal_terkirim'] }}</td>
                        <td class="data-aksi">
                            <a href="{{ route('jurnal.detail', $siswa['siswa']->id) }}">
                                <button class="btn-aksi">Detail</button>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="data-footer">
                        <td colspan="5">
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
@endsection

