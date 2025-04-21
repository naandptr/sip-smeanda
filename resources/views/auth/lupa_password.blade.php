@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('content')
<div class="auth-container">
    <div class="auth-section">
        <div class="auth-brand">
            <img src="{{ asset('img/logo-icon.png') }}" height="49" alt="Logo SMKN 2" loading="lazy"/>
            <h5 class="brand-text">SISTEM INFORMASI PRAKERIN</h5>
        </div>  

        <div class="auth-body">
            <div class="auth-header">
                <h1>LUPA KATA SANDI</h1>
                <h4>Masukkan email Anda yang telah terdaftar. Kami akan mengirimi Anda tautan untuk kembali ke akun Anda.</h4>
            </div>
            <form action="" method="POST" class="auth-form" id="formLupaPassword">
                @csrf
                <div class="auth-group">        
                    <div class="auth-field">
                        <label for="emailUser">Masukkan Email</label>
                        <input type="email" id="emailUser" name="emailUser" required>
                    </div>
                </div>
                <div class="auth-button">
                    <button type="submit" class="btn-submit">Kirim Tautan Masuk</button>
                </div>
            </form>
        </div>
    </div>

    <div class="auth-image">
        <img src="{{ asset('img/ganti-pw.png') }}" alt="Ilustrasi Keamanan Login">
    </div>
</div>
@endsection
