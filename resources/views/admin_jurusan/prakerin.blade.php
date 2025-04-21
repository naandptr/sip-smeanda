@php 
    $page_name = 'admin_jurusan/prakerin'; 
@endphp

@extends('layouts.app')

@section('title', 'Penetapan Siswa')

@section('content')
<div class="data-container">
    <!-- Header -->
    <div class="header">
        <h1>Penetapan Siswa</h1>
    </div>

    <div class="data-section">
        <div class="data-action">
            <button class="btn-open" id="tambahPrakerin" data-bs-toggle="modal" data-bs-target="#modalPrakerin">Tambah Penetapan</button>
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
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="data-body">
                        @foreach ($dataPrakerin as $index => $prakerin)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $prakerin->siswa->nama }}</td>
                            <td>{{ $prakerin->dudiJurusan->dudi->nama_dudi ?? '-' }}</td>
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
                            <td colspan="4">
                                <div class="pagination custom-pagination">
                                    @if ($dataPrakerin->onFirstPage())
                                        <span class="prev disabled">Previous</span>
                                    @else
                                        <a href="{{ $dataPrakerin->previousPageUrl() }}" class="prev">Previous</a>
                                    @endif
                    
                                    <span class="page-info">
                                        {{ $dataPrakerin->firstItem() }}-{{ $dataPrakerin->lastItem() }} of {{ $dataPrakerin->total() }}
                                    </span>
                    
                                    @if ($dataPrakerin->hasMorePages())
                                        <a href="{{ $dataPrakerin->nextPageUrl() }}" class="next">Next</a>
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

@push('page_scripts')
    <script src="{{ asset('js/admin_jurusan/prakerin.js') }}"></script>
@endpush