@php 
    $page_name = 'auth/setup_akun'; 
@endphp

@extends('layouts.auth')

@section('title', 'Setup Akun')

@section('content')
<div class="auth-container">
    <div class="auth-section">
        <div class="auth-brand">
            <img src="{{ asset('img/logo-icon.png') }}" height="49" alt="Logo SMKN 2" loading="lazy"/>
            <h5 class="brand-text">SISTEM INFORMASI PRAKERIN</h5>
        </div>  

        <div class="auth-body">
            <div class="auth-header">
                <h1>SETUP AKUN</h1>
                <h4>Sebelum masuk untuk akses, harap konfirmasi akun Anda.</h4>
            </div>
    
            <form action="{{ route('setup-akun') }}" method="POST" class="auth-form" id="setupForm">
                @csrf
                <div class="auth-group">        
                    <div class="auth-field">
                        <label for="emailUser">Masukkan Email</label>
                        <input type="email" id="emailUser" name="emailUser" required>
                    </div>
                </div>
                <div class="auth-group">        
                    <div class="auth-field">
                        <label for="newPw">Create Password</label>
                        <div class="pass-wrapper">
                            <input type="password" name="newPw" id="newPw" required>
                            <img src="{{ asset('img/hidden-icon.png') }}" class="toggle-password" data-target="newPw" alt="Toggle Password">
                        </div>
                    </div>
                </div>
                <div class="auth-group">        
                    <div class="auth-field">
                        <label for="confirmPw">Re-enter Password</label>
                        <div class="pass-wrapper">
                            <input type="password" name="confirmPw" id="confirmPw" required>
                            <img src="{{ asset('img/hidden-icon.png') }}" class="toggle-password" data-target="confirmPw" alt="Toggle Password">
                        </div>
                    </div>
                </div>
                <div class="auth-button">
                    <button type="submit" class="btn-submit" id="submitSetup">Kirim Tautan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="auth-image">
        <img src="{{ asset('img/ganti-pw.png') }}" alt="Ilustrasi Keamanan Login">
    </div>
</div>
@endsection
