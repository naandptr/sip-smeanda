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
            <a href="{{ route('nilai.form') }}"><button class="btn-open">+ Penilaian</button></a>
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
                        @foreach ($siswaBimbingan as $siswa)
                        <tr>
                            <td>{{ $siswa->nis }}</td>
                            <td>{{ $siswa->nama }}</td>
                            <td>{{ $siswa->kelas->nama_kelas }}</td>
                            <td class="data-aksi">
                                <a href="{{ route('nilai.download', $siswa->penilaian->id) }}">
                                    <button class="btn-aksi">Unduh</button>
                                </a>
                            </td>
                        </tr>
                        @endforeach
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

