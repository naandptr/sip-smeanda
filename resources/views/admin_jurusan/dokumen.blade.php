@extends('layouts.app')

@section('title', 'Dokumen')

@section('content')
<div class="data-container">
    <!-- Header -->
    <div class="header">
        <h1>Dokumen</h1>
    </div>

    <div class="data-section">
        <div class="data-filter">    
            <form method="GET" action="{{ route('jurusan.dokumen') }}">
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
                            <th>SISWA</th>
                            <th>KELAS</th>
                            <th>CV</th>
                            <th>PORTOFOLIO</th>
                            <th>LAPORAN AKHIR</th>
                            <th>SERTIFIKAT</th>
                        </tr>
                    </thead>
                    <tbody class="data-body">
                        @foreach($dataSiswa as $index => $siswa)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $siswa->nama }}</td>
                            <td>{{ $siswa->kelas->nama_kelas }}</td>
                            <td>
                                @php
                                    $cv = $siswa->dokumen->firstWhere('jenis', 'CV');
                                @endphp
                                @if($cv)
                                    <form action="{{ route('dokumen-siswa.download', $cv->id) }}" method="GET" style="display:inline;">
                                        <button type="submit" class="btn-aksi">Unduh</button>
                                    </form>
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $portofolio = $siswa->dokumen->firstWhere('jenis', 'Portofolio');
                                @endphp
                                @if($portofolio)
                                    <form action="{{ route('dokumen-siswa.download', $portofolio->id) }}" method="GET" style="display:inline;">
                                        <button type="submit" class="btn-aksi">Unduh</button>
                                    </form>
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $laporan = $siswa->dokumen->firstWhere('jenis', 'Laporan');
                                @endphp
                                @if($laporan)
                                    <form action="{{ route('dokumen-siswa.download', $laporan->id) }}" method="GET" style="display:inline;">
                                        <button type="submit" class="btn-aksi">Unduh</button>
                                    </form>
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $sertifikat = $siswa->dokumen->firstWhere('jenis', 'Sertifikat');
                                @endphp
                                @if($sertifikat)
                                    <form action="{{ route('dokumen-siswa.download', $sertifikat->id) }}" method="GET" style="display:inline;">
                                        <button type="submit" class="btn-aksi">Unduh</button>
                                    </form>
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="data-footer">
                            <td colspan="7">
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
