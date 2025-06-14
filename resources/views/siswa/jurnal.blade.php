@php 
    $page_name = 'siswa/jurnal'; 
    use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('title', 'Jurnal Kegiatan')

@section('content')
<div class="jurnal data-container">
    <div class="header">
        <h1>Jurnal Kegiatan</h1>
    </div>

    <div class="jurnal-section data-section">
        <div class="jurnal-action data-action">
            <button type="button" class="btn-open" id="tambahJurnal" data-bs-toggle="modal" data-bs-target="#modalJurnal">+ Jurnal</button>
            <x-modal_jurnal></x-modal_jurnal>
        </div>

        <div class="jurnal-content data-content">
            <div class="table-wrapper">
                <table class="jurnal-table data-table">
                    <thead class="jurnal-header data-header">
                        <tr>
                            <th>NO</th>
                            <th>TANGGAL</th>
                            <th>DESKRIPSI</th>
                            <th>STATUS</th>
                            <th>CATATAN</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="jurnal-body data-body">
                        @foreach ($dataJurnal as $jurnal)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d/m/Y') }}</td>
                            <td>
                                <div class="deskripsi-cell">
                                    {!! limitHtml($jurnal->deskripsi, 50) !!}
                                </div>
                            </td>                                                               
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
                            <td><div class="deskripsi-cell">
                                {!! Str::limit(strip_tags($jurnal->validasi->catatan ?? '-'), 50) !!}
                            </div></td>
                            <td class="data-aksi">
                                <button class="btn-icon" data-bs-toggle="modal" data-bs-target="#modalDetailJurnal-{{ $jurnal->id }}">
                                    <img src="{{ asset('img/show-icon.png') }}" alt="Lihat">
                                </button>
                                <x-modal_detail_jurnal :jurnal="$jurnal" :modalId="'modalDetailJurnal-' . $jurnal->id" />
                                @php
                                    $sudahValidasi = \App\Models\Validasi::where('jurnal_id', $jurnal->id)
                                        ->where('status_validasi', 'Selesai')
                                        ->exists();
                                @endphp
    
                                @if (!$sudahValidasi)
                                    <button class="btn-icon deleteJurnal" data-id="{{ $jurnal->id }}">
                                        <img src="{{ asset('img/hapus-icon.png') }}" alt="Hapus">
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="jurnal-footer data-footer">
                            <td colspan="6">
                                <div class="pagination custom-pagination">
                                    @if ($dataJurnal->onFirstPage())
                                        <span class="prev disabled">Sebelumnya</span>
                                    @else
                                        <a href="{{ $dataJurnal->previousPageUrl() }}" class="prev">Sebelumnya</a>
                                    @endif
                    
                                    <span class="page-info">
                                        {{ $dataJurnal->firstItem() }}-{{ $dataJurnal->lastItem() }} dari {{ $dataJurnal->total() }}
                                    </span>
                    
                                    @if ($dataJurnal->hasMorePages())
                                        <a href="{{ $dataJurnal->nextPageUrl() }}" class="next">Selanjutnya</a>
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
