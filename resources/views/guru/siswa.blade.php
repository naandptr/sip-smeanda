@extends('layouts.app')

@section('title', 'Siswa Bimbingan')

@section('content')
<div class="data-container">
    <!-- Header -->
    <div class="header">
        <h1>Siswa Bimbingan</h1>
    </div>

    <div class="data-section">
        <!-- Tabel Buat Absen-->
        <div class="data-content">
            <table class="data-table">
                <thead class="data-header">
                    <tr>
                        <th>NIS</th>
                        <th>SISWA</th>
                        <th>KELAS</th>
                        <th>STATUS PRAKERIN</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody class="data-body">
                    @foreach ($dataSiswa as $index => $siswa)
                    <tr>
                        <td>{{ $siswa->nis }}</td>
                        <td>{{ $siswa->nama }}</td>
                        <td>{{ $siswa->kelas->nama_kelas }}</td>
                        @php
                            $status = strtolower($siswa->penetapanPrakerin->first()?->status ?? 'belum_dimulai');
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
                            <button type="button" class="btn-icon" data-bs-toggle="modal" data-bs-target="#modalDetailSiswaBimbingan-{{ $siswa->id }}">
                                <img src="{{ asset('img/show-icon.png') }}" alt="Lihat">
                            </button>
                            <x-modal_detail_siswa_bimbingan :siswa="$siswa" 
                            :penetapan="$siswa->penetapanPrakerin->first()"
                            :modalId="'modalDetailSiswaBimbingan-' . $siswa->id" />
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
