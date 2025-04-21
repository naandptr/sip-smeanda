@extends('layouts.app')

@section('title', 'Dokumen')

@section('content')
<div class="data-container">
    <!-- Header -->
    <div class="header">
        <h1>Dokumen</h1>
    </div>

    <div class="data-section">
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
