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
                        <th>CAPAIAN</th>
                        <th style="width: 250px;">AKSI</th>
                    </tr>
                </thead>
                <tbody class="data-body">
                    @foreach ($siswaBimbingan as $siswa)
                    <tr>
                        <td>{{ $siswa['siswa']->nis }}</td>
                        <td>{{ $siswa['siswa']->nama }}</td>
                        <td>{{ $siswa['kelas'] }}</td>
                        <td>{{ $siswa['jurnal_validasi'] }}/{{ $siswa['jurnal_terkirim'] }}</td>
                        <td class="data-aksi">
                            <a href="{{ route('jurnal.detail', $siswa['siswa']->id) }}">
                                <button class="btn-aksi">Detail</button>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="data-footer">
                        <td colspan="5">
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

