@extends('layouts.app')

@section('title', 'Akun')

@section('content')
<div class="akun">
    <div class="header">
        <h1>Akun</h1>
    </div>
    <div class="info-akun">
        <table class="item-user">
            <tr>
                <td style="width: 30%;">Nama</td>
                <td style="width: 70%;">Arslan Allen</td>
            </tr>
            <tr>
                <td>NIS</td>
                <td>0031652858</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>XII Animasi 1</td>
            </tr>
            <tr>
                <td>Jurusan</td>
                <td>Animasi</td>
            </tr>
        </table>
    </div>
    <div class="pw-btn"><a href="{{ url('/siswa/change_pass') }}"><button class="btn-open">Ganti Password</button></a></div>
</div>
@endsection
