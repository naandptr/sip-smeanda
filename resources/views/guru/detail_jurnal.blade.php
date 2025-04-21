@php 
    $page_name = 'guru/detail_jurnal'; 
@endphp

@extends('layouts.app')

@section('title', 'Jurnal Kegiatan Siswa')

@section('content')
<div class="data-container">
    <!-- Header -->
    <div class="header">
        <h1>Jurnal Kegiatan Siswa</h1>
    </div>

    <div class="data-section">
        <!-- Tabel Jurnal-->
        <div class="data-content">
            <div class="table-wrapper"></div>
            <table class="data-table">
                <thead class="data-header">
                    <tr>
                        <th>NIS</th>
                        <th>SISWA</th>
                        <th>KELAS</th>
                        <th>TANGGAL</th>
                        <th>STATUS</th>
                        <th style="width: 250px;">AKSI</th>
                    </tr>
                </thead>
                <tbody class="data-body">
                    @foreach ($jurnalList as $jurnal)
                    <tr>
                        <td>{{ $siswa->nis }}</td>
                        <td>{{ $siswa->nama }}</td>
                        <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d/m/Y') }}</td>
                        <td>
                            @php
                                    $status = strtolower($jurnal->validasi->status_validasi ?? '-');
                                    $badgeClass = match($status) {
                                        'menunggu' => 'pending',
                                        'selesai' => 'selesai',
                                        default => '',
                                    };
                            @endphp
                            <div class="status-badge {{ $badgeClass }}">{{ $jurnal->validasi->status_validasi ?? '-' }}</div>
                        </td>
                        <td class="data-aksi">
                            <!-- Tombol Lihat -->
                            <button type="button" class="btn-icon btn-open-jurnal" data-bs-toggle="modal" data-bs-target="#modalDetailJurnal{{ $jurnal->id }}">
                                <img src="{{ asset('img/show-icon.png') }}" alt="Lihat">
                            </button>
                            <x-modal_detail_jurnal :jurnal="$jurnal" :modalId="'modalDetailJurnal'.$jurnal->id" />


                            <!-- Tombol Validasi -->
                            @php
                                $sudahValidasi = \App\Models\Validasi::where('jurnal_id', $jurnal->id)
                                    ->where('status_validasi', 'Selesai')
                                    ->exists();
                            @endphp

                            @if (!$sudahValidasi)
                                <button class="btn-validasi" data-bs-toggle="modal" data-bs-target="#modalValidasiJurnal{{ $jurnal->id }}">
                                    Validasi
                                </button>
                            @endif
                            <x-modal_validasi :jurnal="$jurnal" />
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="data-footer">
                        <td colspan="6">
                            <div class="pagination">
                                <span class="prev">Previous</span>
                                <span class="page-info">1-3 of 3</span>
                                <span class="next">Next</span>
                            </div>
                        </td>
                    </tr>
                </tfoot>                
            </table>
        </div>
    </div>
</div>
@endsection
