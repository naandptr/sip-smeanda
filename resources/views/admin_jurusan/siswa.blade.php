@extends('layouts.app')

@section('title', 'Siswa Jurusan')

@section('content')
<div class="data-container">
    <div class="header">
        <h1>Siswa Jurusan</h1>
    </div>

    <div class="data-section">
        <div class="data-filter">    
            <form method="GET" action="{{ route('jurusan.siswa') }}">
                <div class="filter-value">
                    <select name="tahun_ajaran">
                        <option value="">Pilih Tahun Ajaran</option>
                        @foreach ($dataTahunAjaran as $tahun)
                            <option value="{{ $tahun->id }}" {{ request('tahun_ajaran') == $tahun->id ? 'selected' : '' }}>
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
        <div class="data-content">
            <div class="table-wrapper">
                <table class="data-table">
                    <thead class="data-header">
                        <tr>
                            <th>NO</th>
                            <th>NISN</th>
                            <th>SISWA</th>
                            <th>KELAS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="data-body">
                        @foreach ($dataSiswa as $index => $siswa)
                        <tr>
                            <td>{{ $loop->iteration }}</td> 
                            <td>{{ $siswa->nis }}</td>
                            <td>{{ $siswa->nama }}</td>
                            <td>{{ $siswa->kelas->nama_kelas }}</td>
                            <td class="data-aksi">
                                <button type="button" class="btn-icon" data-bs-toggle="modal" data-bs-target="#modalDetailSiswaJurusan-{{ $siswa->id }}">
                                    <img src="{{ asset('img/show-icon.png') }}" alt="Lihat">
                                </button>
                                <x-modal_detail_siswa_jurusan :siswa="$siswa" 
                                :penetapan="$siswa->penetapanPrakerin->first()"
                                :modalId="'modalDetailSiswaJurusan-' . $siswa->id" />
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="data-footer">
                            <td colspan="5">
                                <div class="pagination custom-pagination">
                                    @if ($dataSiswa->onFirstPage())
                                        <span class="prev disabled">Sebelumnya</span>
                                    @else
                                        <a href="{{ $dataSiswa->previousPageUrl() }}" class="prev">Sebelumnya</a>
                                    @endif
                    
                                    <span class="page-info">
                                        {{ $dataSiswa->firstItem() }}-{{ $dataSiswa->lastItem() }} dari {{ $dataSiswa->total() }}
                                    </span>
                    
                                    @if ($dataSiswa->hasMorePages())
                                        <a href="{{ $dataSiswa->nextPageUrl() }}" class="next">Selanjutnya</a>
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
