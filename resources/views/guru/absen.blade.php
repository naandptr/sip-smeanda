@extends('layouts.app')

@section('title', 'Absen Harian Siswa')

@section('content')
<div class="data-container">
    <!-- Header -->
    <div class="header">
        <h1>Absen Harian Siswa</h1>
    </div>

    <div class="data-section">
        <!-- Tabel Absensi -->
        <div class="data-content">
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
                        <td>0031652858</td>
                        <td>Arslan Allen</td>
                        <td>XII Animasi I</td>
                        <td class="data-aksi">
                            <a href="{{ url('/guru/detail_absen') }}"><button class="btn-aksi">Detail</button></a>
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
@endsection
