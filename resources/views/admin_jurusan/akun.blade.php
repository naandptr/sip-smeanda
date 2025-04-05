@extends('layouts.app')

@section('title', 'Akun')

@section('content')
<div class="data-container">
    <div class="header">
        <h1>Akun</h1>
    </div>
    <div class="info-akun">
        <table class="item-user">
            <tr>
                <td style="width: 30%;">Nama</td>
                <td style="width: 70%;">Admin Jurusan</td>
            </tr>
            <tr>
                <td>Jurusan</td>
                <td>Animasi</td>
            </tr>
        </table>
    </div>
    <div class="pw-btn"><a href="{{ url('/admin_jurusan/change_pass?role=admin_jurusan') }}"><button class="btn-open">Ganti Password</button></a></div>
</div>
@endsection
