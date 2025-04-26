@php 
    $page_name = 'admin_jurusan/prakerin'; 
@endphp

@extends('layouts.app')

@section('title', 'Penetapan Prakerin')

@section('content')
<div class="data-container">
    <div class="header">
        <h1>Penetapan Prakerin</h1>
    </div>

    <div class="data-section">
        <div class="data-filter">
            <form method="GET" action="{{ route('jurusan.prakerin') }}">
                <div class="filter-value">
                    <select name="tahun_ajaran">
                        <option value="">Pilih Tahun Ajaran</option>
                        @foreach ($tahunAjar as $tahun)
                            <option value="{{ $tahun->id }}" {{ request('tahun_ajaran', $tahunAjarAktif->id) == $tahun->id ? 'selected' : '' }}>
                                {{ $tahun->tahun_ajaran }}
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
            <button class="btn-open" id="tambahPrakerin" data-bs-toggle="modal" data-bs-target="#modalPrakerin">+ Penetapan</button>
            <x-modal_prakerin :siswa="$siswa" :dudiJurusan="$dudiJurusan" :tahunAjar="$tahunAjar" />
        </div>
        <div class="data-content">
            <div class="table-wrapper">
                <table class="data-table">
                    <thead class="data-header">
                        <tr>
                            <th>NO</th>
                            <th>NAMA</th>
                            <th>PENETAPAN DUDI</th>
                            <th>TAHUN AJARAN</th>
                            <th>STATUS PRAKERIN</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="data-body">
                        @foreach ($dataPrakerin as $index => $prakerin)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $prakerin->siswa->nama }}</td>
                            <td>{{ $prakerin->dudiJurusan->dudi->nama_dudi ?? '-' }}</td>
                            <td>{{ $prakerin->tahunAjar->tahun_ajaran ?? '-' }}</td>
                            @php
                                $status = strtolower($prakerin->status ?? 'belum_dimulai');
                                $statusClass = match($status) {
                                    'belum_dimulai' => 'not-started',
                                    'berlangsung' => 'ongoing',
                                    'selesai' => 'selesai',
                                    'dibatalkan' => 'canceled',
                                    default => 'not-started',
                                };
                                $statusLabel = match($status) {
                                    'belum_dimulai' => 'BELUM DIMULAI',
                                    'berlangsung' => 'BERLANGSUNG',
                                    'selesai' => 'SELESAI',
                                    'dibatalkan' => 'DIBATALKAN',
                                    default => 'BELUM DIMULAI',
                                };
                            @endphp
                            <td><div class="status-badge {{ $statusClass }}">{{ $statusLabel }}</div></td>
                            <td class="data-aksi">
                                <!-- Tombol Lihat -->
                                <button class="btn-icon" data-bs-toggle="modal" data-bs-target="#modalDetailPrakerin-{{ $prakerin->id }}">
                                    <img src="{{ asset('img/show-icon.png') }}" alt="Lihat">
                                </button>
                                <x-modal_detail_prakerin :prakerin="$prakerin" :modalId="'modalDetailPrakerin-' .$prakerin->id" />

                                <button class="btn-icon editPrakerin" data-id="{{ $prakerin->id }}">
                                    <img src="{{ asset('img/edit-icon.png') }}" alt="Edit">
                                </button>
                                <button class="btn-icon deletePrakerin" data-id="{{ $prakerin->id }}">
                                    <img src="{{ asset('img/hapus-icon.png') }}" alt="Hapus">
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="data-footer">
                            <td colspan="6">
                                <div class="pagination custom-pagination">
                                    @if ($dataPrakerin->onFirstPage())
                                        <span class="prev disabled">Sebelumnya</span>
                                    @else
                                        <a href="{{ $dataPrakerin->previousPageUrl() }}" class="prev">Sebelumnya</a>
                                    @endif
                    
                                    <span class="page-info">
                                        {{ $dataPrakerin->firstItem() }}-{{ $dataPrakerin->lastItem() }} dari {{ $dataPrakerin->total() }}
                                    </span>
                    
                                    @if ($dataPrakerin->hasMorePages())
                                        <a href="{{ $dataPrakerin->nextPageUrl() }}" class="next">Selanjutnya</a>
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

@push('page_scripts')
    <script src="{{ asset('js/admin_jurusan/prakerin.js') }}"></script>
@endpush