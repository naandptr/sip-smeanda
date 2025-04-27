@php 
    $page_name = 'guru/detail_presensi'; 
@endphp

@extends('layouts.app')

@section('title', 'Presensi Harian Siswa')

@section('content')
<div class="data-container">
    <div class="header">
        <h1>Presensi Harian Siswa</h1>
    </div>

    <div class="data-section">
        <div class="data-content">
            <table class="data-table">
                <thead class="data-header">
                    <tr>
                        <th>NIS</th>
                        <th>SISWA</th>
                        <th>KELAS</th>
                        <th>TANGGAL</th>
                        <th>JENIS PRESENSI</th>
                        <th>STATUS</th>
                        <th>KETERANGAN</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody class="data-body">
                    @foreach ($dataPresensi as $presensi)
                    <tr>
                        <td>{{ $siswa->nis }}</td>
                        <td>{{ $siswa->nama }}</td>
                        <td>{{ $siswa->kelas->nama_kelas }}</td>
                        <td>{{ \Carbon\Carbon::parse($presensi->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ $presensi->jenis_presensi }}</td>
                        <td>{{ $presensi->status_kehadiran ?? '-' }}</td>
                        <td>{{ $presensi->keterangan ?? '-' }}</td>
                        <td class="data-aksi">
                            <button type="button" class="btn-icon show-detail-presensi"
                                    data-bs-toggle="modal" data-bs-target="#modalDetailPresensi"
                                    data-file-url="{{ Storage::url($presensi->file) }}">
                                    <img src="{{ asset('img/show-icon.png') }}" alt="Detail">
                                </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <x-modal_detail_presensi />
                <tfoot>
                    <tr class="data-footer">
                        <td colspan="8">
                            <div class="pagination custom-pagination">
                                @if ($dataPresensi->onFirstPage())
                                    <span class="prev disabled">Sebelumnya</span>
                                @else
                                    <a href="{{ $dataPresensi->previousPageUrl() }}" class="prev">Sebelumnya</a>
                                @endif
                
                                <span class="page-info">
                                    {{ $dataPresensi->firstItem() }}-{{ $dataPresensi->lastItem() }} dari {{ $dataPresensi->total() }}
                                </span>
                
                                @if ($dataPresensi->hasMorePages())
                                    <a href="{{ $dataPresensi->nextPageUrl() }}" class="next">Selanjutnya</a>
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
@endsection
