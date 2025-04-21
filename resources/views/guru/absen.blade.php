@extends('layouts.app')

@section('title', 'Absen Harian Siswa')

@section('content')
<div class="data-container">
    <div class="header">
        <h1>Absen Harian Siswa</h1>
    </div>

    <div class="data-section">
        <div class="data-content">
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
                    <tr>
                        <td>{{ $siswa->nis }}</td>
                        <td>{{ $siswa->nama }}</td>
                        <td>{{ $siswa->kelas->nama_kelas }}</td>
                        <td class="data-aksi">
                            <a href="{{ route('absen-detail.guru', $siswa->id) }}">
                                <button class="btn-aksi">Detail</button>
                            </a>
                        </td>
                    </tr>
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
@endsection
