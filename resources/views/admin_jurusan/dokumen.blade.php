@extends('layouts.app')

@section('title', 'Dokumen')

@section('content')
<div class="data-container">
    <!-- Header -->
    <div class="header">
        <h1>Dokumen</h1>
    </div>

    <div class="data-section">
        <div class="data-content">
            <div class="table-wrapper">
                <table class="data-table">
                    <thead class="data-header">
                        <tr>
                            <th>NO</th>
                            <th>SISWA</th>
                            <th>KELAS</th>
                            <th>CV</th>
                            <th>PORTOFOLIO</th>
                            <th>LAPORAN AKHIR</th>
                            <th>SERTIFIKAT</th>
                        </tr>
                    </thead>
                    <tbody class="data-body">
                        <tr>
                            <td>1</td>
                            <td>Arslan Allen</td>
                            <td>XII Animasi I</td>
                            <td>
                                <button class="btn-aksi">
                                    Unduh
                                </button>
                            </td>
                            <td>
                                <button class="btn-aksi">
                                    Unduh
                                </button>
                            </td>
                            <td>
                                <button class="btn-aksi">
                                    Unduh
                                </button>
                            </td>
                            <td>
                                <button class="btn-aksi">
                                    Unduh
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="data-footer">
                            <td colspan="7">
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
