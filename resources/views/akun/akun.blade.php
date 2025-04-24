
@extends('layouts.app')

@section('title', 'Akun')

@section('content')
<div class="data-container">
    <div class="header">
        <h1>Akun</h1>
    </div>

    @php
        use App\Models\User;
        $role = Auth::user()->role ?? User::ROLE_SISWA; 
    @endphp
    
    <div class="info-akun">
        <table class="item-user">    
            @if ($role === User::ROLE_GURU)
            <tr>
                <td style="width: 30%;">Nama</td>
                <td style="width: 70%;">{{ Auth::user()->pembimbing->nama }}</td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>{{ Auth::user()->pembimbing->nip }}</td>
            </tr>
            @elseif ($role === User::ROLE_SISWA)
            <tr>
                <td style="width: 30%;">Nama</td>
                <td style="width: 70%;">{{ Auth::user()->siswa->nama }}</td>
            </tr>
            <tr>
                <td>NIS</td>
                <td>{{ Auth::user()->siswa->nis }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>{{ Auth::user()->siswa->kelas->nama_kelas }}</td>
            </tr>
            <tr>
                <td>Jurusan</td>
                <td>{{ Auth::user()->siswa->kelas->jurusan->nama_jurusan }}</td>
            </tr>
            @elseif ($role === User::ROLE_ADMIN_JURUSAN)
            <tr>
                <td style="width: 30%;">Nama</td>
                <td style="width: 70%;">{{ Auth::user()->adminJurusan->nama }}</td>
            </tr>
            <tr>
                <td>Jurusan</td>
                <td>{{ Auth::user()->adminJurusan->jurusan->nama_jurusan }}</td>
            </tr>
            @endif
        </table>
    </div>

    <div class="pw-btn">
        <a href="{{ route('akun.show.ganti_password') }}">
            <button class="btn-open">Ganti Kata Sandi</button>
        </a>
    </div>
</div>
@endsection
