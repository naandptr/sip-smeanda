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
                <td style="width: 70%;">Siti Menenun</td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>12345678930110711</td>
            </tr>
        </table>
    </div>
    <div class="pw-btn"><a href="{{ url('/guru/change_pass?role=guru') }}"><button class="btn-open">Ganti Password</button></a></div>
</div>
@endsection
