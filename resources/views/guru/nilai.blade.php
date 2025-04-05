@php 
    $page_name = 'guru/nilai'; 
@endphp


@extends('layouts.app')

@section('title', 'Penilaian')

@section('content')
<div class="data-container">
    <!-- Header -->
    <div class="header">
        <h1>Penilaian</h1>
    </div>

    <div class="data-section">
        <div class="data-action">
            <a href="{{ url('/guru/tambah_nilai') }}"><button class="btn-open">+ Penilaian</button></a>
        </div>
        <div class="data-content">
            <div class="table-wrapper">
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
                        <tr>
                            <td>321323314</td>
                            <td>Arslan Allen</td>
                            <td>XII Animasi 1</td>
                            <td class="data-aksi">
                                <button class="btn-aksi">
                                    Unduh
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="data-footer">
                            <td colspan="4">
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
</div>
@endsection

@push('page_scripts')
    <script src="{{ asset('js/guru/nilai.js') }}"></script>
@endpush
