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
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody class="data-body">
                    @foreach ($siswa as $index => $s)
                    <tr>
                        <td>{{ $s->nisn }}</td>
                        <td>{{ $s->nama }}</td>
                        <td>{{ $s->kelas->nama_kelas }}</td>
                        <td><div class="status-badge">SELESAI</div></td>
                        <td class="data-aksi">
                            <button type="button" class="btn-icon" data-bs-toggle="modal" data-bs-target="#modalDetailSiswaBimbingan-{{ $s->id }}">
                                <img src="{{ asset('img/show-icon.png') }}" alt="Lihat">
                            </button>
                            <x-modal_detail_siswa_bimbingan :siswa="$s" 
                            :penetapan="$s->penetapanPrakerin->first()"
                            :modalId="'modalDetailSiswaBimbingan-' . $s->id" />
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="siswa-footer">
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
