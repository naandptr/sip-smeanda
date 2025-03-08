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
            <button class="btn-open btn-open-penilaian" data-bs-toggle="modal" data-bs-target="#modalPenilaian">Buat Penilaian</button>
            <x-modal_nilai></x-modal_nilai>
        </div>
        <div class="data-content">
            <div class="table-wrapper">
                <table class="data-table">
                    <thead class="data-header">
                        <tr>
                            <th>NO</th>
                            <th>NAMA</th>
                            <th>NAMA DUDI</th>
                            <th>SIKAP</th>
                            <th>PENGETAHUAN</th>
                            <th>KETERAMPILAN</th>
                            <th>TOTAL NILAI</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="data-body">
                        <tr>
                            <td>1</td>
                            <td>Arslan Allen</td>
                            <td>PT. ABCD Animax Jaya</td>
                            <td>85</td>
                            <td>90</td>
                            <td>88</td>
                            <td>88.4</td>
                            <td class="btn-aksi">
                                <!-- Tombol Lihat -->
                                <button class="btn-icon">
                                    <img src="{{ asset('img/show-icon.png') }}" alt="Lihat">
                                </button>

                                <!-- Tombol Edit -->
                                <button class="btn-icon">
                                    <img src="{{ asset('img/edit-icon.png') }}" alt="Edit">
                                </button>
                                <!-- Tombol Hapus -->
                                <button class="btn-icon">
                                    <img src="{{ asset('img/hapus-icon.png') }}" alt="Hapus">
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="data-footer">
                            <td colspan="6">
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
