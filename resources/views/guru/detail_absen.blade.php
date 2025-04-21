@php 
    $page_name = 'guru/detail_absen'; 
@endphp

@extends('layouts.app')

@section('title', 'Absen Harian Siswa')

@section('content')
<div class="data-container">
    <!-- Header -->
    <div class="header">
        <h1>Absen Harian Siswa</h1>
    </div>

    <div class="data-section">
        <!-- Tabel Absensi -->
        <div class="data-content">
            <table class="data-table">
                <thead class="data-header">
                    <tr>
                        <th>NIS</th>
                        <th>SISWA</th>
                        <th>KELAS</th>
                        <th>TANGGAL</th>
                        <th>JENIS ABSEN</th>
                        <th>STATUS</th>
                        <th>KETERANGAN</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody class="data-body">
                    @foreach ($dataAbsen as $absen)
                    <tr>
                        <td>{{ $siswa->nis }}</td>
                        <td>{{ $siswa->nama }}</td>
                        <td>{{ $siswa->kelas->nama_kelas }}</td>
                        <td>{{ \Carbon\Carbon::parse($absen->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ $absen->jenis_absen }}</td>
                        <td>{{ $absen->status_kehadiran ?? '-' }}</td>
                        <td>{{ $absen->keterangan ?? '-' }}</td>
                        <td class="data-aksi">
                            <button type="button" class="btn-icon show-detail-absen"
                                    data-bs-toggle="modal" data-bs-target="#modalDetailAbsen"
                                    data-file-url="{{ Storage::url($absen->file) }}">
                                    <img src="{{ asset('img/show-icon.png') }}" alt="Detail">
                                </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <x-modal_detail_absen></x-modal_detail_absen>
                <tfoot>
                    <tr class="data-footer">
                        <td colspan="8">
                            <div class="pagination custom-pagination">
                                @if ($dataAbsen->onFirstPage())
                                    <span class="prev disabled">Previous</span>
                                @else
                                    <a href="{{ $dataAbsen->previousPageUrl() }}" class="prev">Previous</a>
                                @endif
                
                                <span class="page-info">
                                    {{ $dataAbsen->firstItem() }}-{{ $dataAbsen->lastItem() }} of {{ $dataAbsen->total() }}
                                </span>
                
                                @if ($dataAbsen->hasMorePages())
                                    <a href="{{ $dataAbsen->nextPageUrl() }}" class="next">Next</a>
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
