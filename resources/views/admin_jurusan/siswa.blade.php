@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')
<div class="data-container">
    <!-- Header -->
    <div class="header">
        <h1>Data Siswa</h1>
    </div>

    <div class="data-section">
        <div class="data-content">
            <div class="table-wrapper">
                <table class="data-table">
                    <thead class="data-header">
                        <tr>
                            <th>NO</th>
                            <th>NISN</th>
                            <th>SISWA</th>
                            <th>KELAS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="data-body">
                        @foreach ($siswa as $index => $s)
                        <tr>
                            <td>{{ $loop->iteration }}</td> 
                            <td>{{ $s->nisn }}</td>
                            <td>{{ $s->nama }}</td>
                            <td>{{ $s->kelas->nama_kelas }}</td>
                            <td class="data-aksi">
                                <button type="button" class="btn-icon" data-bs-toggle="modal" data-bs-target="#modalDetailSiswaJurusan-{{ $s->id }}">
                                    <img src="{{ asset('img/show-icon.png') }}" alt="Lihat">
                                </button>
                                <x-modal_detail_siswa_jurusan :siswa="$s" 
                                :penetapan="$s->penetapanPrakerin->first()"
                                :modalId="'modalDetailSiswaJurusan-' . $s->id" />
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
</div>
@endsection
