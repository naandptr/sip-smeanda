@extends('layouts.app')

@section('title', 'Data Penetapan')

@section('content')
<div class="data-container">
    <!-- Header -->
    <div class="header">
        <h1>Data Penetapan</h1>
    </div>

    <div class="data-section">
        <div class="data-action">
            <button class="btn-open btn-open-penetapan" data-bs-toggle="modal" data-bs-target="#modalPenetapan">Buat Penetapan</button>
            <x-modal_penetapan></x-modal_penetapan>
        </div>
        <div class="data-content">
            <div class="table-wrapper">
                <table class="data-table">
                    <thead class="data-header">
                        <tr>
                            <th>NO</th>
                            <th>NAMA</th>
                            <th>KELAS</th>
                            <th>NAMA DUDI</th>
                            <th>PEMBIMBING</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="data-body">
                        <tr>
                            <td>1</td>
                            <td>Arslan Allen</td>
                            <td>XII Animasi I</td>
                            <td>PT. ABCD Animax Jaya</td>
                            <td>Siti Menenun</td>
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
