@php 
    $page_name = 'guru/tambah_nilai'; 
@endphp

<meta name="hapus-icon-url" content="{{ asset('img/hapus-icon.png') }}">

@extends('layouts.app')

@section('title', 'Penilaian')

@section('content')
<div class="data-container">
    <!-- Header -->
    <div class="header">
        <h1>Penilaian</h1>
    </div>

    <div class="data-section">
        <form action="{{ route('nilai.store') }}" method="POST" id="formNilai">
            @csrf
            <div class="nilai-form-container">
                <div class="nilai-form-header">
                    <div class="nilai-header-info">
                        <div class="nilai-header-label">
                            <label for="siswaBimbingan">Nama Peserta Didik</label>
                        </div>
                        <div class="nilai-header-value">
                            <select name="siswaBimbingan" id="siswaBimbingan">
                                <option value="" selected disabled>Pilih Siswa</option>
                                @foreach($siswaBimbingan as $siswa)
                                    <option value="{{ $siswa->id }}">{{ $siswa->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="nilai-header-info">
                        <div class="nilai-header-label">NIS</div>
                        <div class="nilai-header-value" data-field="nis">-</div>
                    </div>
                    <div class="nilai-header-info">
                        <div class="nilai-header-label">Kelas</div>
                        <div class="nilai-header-value" data-field="kelas">-</div>
                    </div>
                    <div class="nilai-header-info">
                        <div class="nilai-header-label">Program Keahlian</div>
                        <div class="nilai-header-value" data-field="program_keahlian">-</div>
                    </div>
                    <div class="nilai-header-info">
                        <div class="nilai-header-label">Konsentrasi Keahlian</div>
                        <div class="nilai-header-value" data-field="konsentrasi_keahlian">-</div>
                    </div>
                    <div class="nilai-header-info">
                        <div class="nilai-header-label">Tempat PKL</div>
                        <div class="nilai-header-value" data-field="tempat_pkl">-</div>
                    </div>
                    <div class="nilai-header-info">
                        <div class="nilai-header-label">Tanggal PKL</div>
                        <div class="nilai-header-value" data-field="tanggal_pkl">-</div>
                    </div>
                    <div class="nilai-header-info">
                        <div class="nilai-header-label">
                            <label for="namaInstruktur">Nama Instruktur</label>
                        </div>
                        <div class="nilai-header-value">
                            <input type="text" name="namaInstruktur" id="namaInstruktur">
                        </div>
                    </div>
                    <div class="nilai-header-info">
                        <div class="nilai-header-label">Nama Pembimbing</div>
                        <div class="nilai-header-value" data-field="pembimbing">-</div>
                    </div>
                </div>

                @if ($errors->has('error'))
                    <div class="alert alert-danger">
                        {{ $errors->first('error') }}
                    </div>
                @endif


                <div class="nilai-form-body">
                    <div class="nilai-form-section">
                        <div class="data-action">
                            <button type="button" class="btn-open" id="tambahDetailNilai" data-bs-toggle="modal" data-bs-target="#modalNilai">+ Nilai</button>
                        </div>
                        <div class="data-content">
                            <div class="table-wrapper">
                                <table class="data-table">
                                    <thead class="data-header">
                                        <tr>
                                            <th>NO</th>
                                            <th>TUJUAN PEMBELAJARAN</th>
                                            <th>SKOR</th>
                                            <th>DESKRIPSI</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody class="data-body">
                                        @foreach($detailNilaiSementara as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item['tujuan_pembelajaran'] }}</td>
                                                <td>{{ $item['skor'] }}</td>
                                                <td>{{ $item['deskripsi'] }}</td>
                                                <td>
                                                    <button class="btn-icon deleteDetailNilai" data-index="{{ $index }}">
                                                        <img src="{{ asset('img/hapus-icon.png') }}" alt="Hapus">
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>                                       
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="nilai-form-section catatan-nilai">
                        <label for="">Catatan:</label>
                        <textarea name="catatan" id="" cols="30" rows="10"></textarea>
                    </div>

                    <div class="nilai-form-section">
                        <div class="data-content">
                            <table class="data-table">
                                <thead class="data-header">
                                    <tr>
                                        <th colspan="2">KETIDAKHADIRAN</th>
                                    </tr>
                                </thead>
                                <tbody class="data-body">
                                    <tr>
                                        <td><label for="jumlahSakit">Sakit</label></td>
                                        <td><input type="text" name="jumlahSakit" id="jumlahSakit"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="jumlahIjin">Ijin</label></td>
                                        <td><input type="text" name="jumlahIjin" id="jumlahIjin"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="jumlahAlpa">Tanpa Keterangan</label></td>
                                        <td><input type="text" name="jumlahAlpa" id="jumlahAlpa"></td>
                                    </tr>
                                </tbody>             
                            </table>
                        </div>
                    </div>
                </div>
                <div class="nilai-form-footer">
                    <button type="button" class="btn-cancel">Cancel</button>
                    <button type="submit" class="btn-submit" id="submitNilai">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
<x-modal_nilai></x-modal_nilai>
<script>
    var routeUrl = "{{ route('nilai.store') }}";
</script>
