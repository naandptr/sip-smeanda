@php 
    $page_name = 'auth/ganti_password_awal'; 
@endphp

@extends('layouts.auth')

@section('title', 'Ganti Password')

@section('content')
<div class="auth-container">
    <div class="auth-section">
        <div class="auth-brand">
            <img src="{{ asset('img/logo-icon.png') }}" height="49" alt="Logo SMKN 2" loading="lazy"/>
            <h5 class="brand-text">SISTEM INFORMASI PRAKERIN</h5>
        </div>  

        <div class="auth-body">
            <div class="auth-header">
                <h1>PERBARUI KATA SANDI</h1>
                <h4>Perbaru kata sandi Anda.</h4>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('ganti-password-awal.store') }}" method="POST" class="auth-form" id="formGantiPasswordAwal">
                @csrf         
                <div class="auth-group">        
                    <div class="auth-field">
                        <label for="newPw">Buat Kata Sandi</label>
                        <div class="pass-wrapper">
                            <input type="password" name="new-pw" id="newPw" required>
                            <img src="{{ asset('img/hidden-icon.png') }}" class="toggle-password" data-target="newPw" alt="Toggle Password">
                        </div>
                    </div>
                </div>
                <div class="auth-group">        
                    <div class="auth-field">
                        <label for="confirmPw">Konfirmasi Kata Sandi</label>
                        <div class="pass-wrapper">
                            <input type="password" name="confirm-pw" id="confirmPw" required>
                            <img src="{{ asset('img/hidden-icon.png') }}" class="toggle-password" data-target="confirmPw" alt="Toggle Password">
                        </div>
                    </div>
                </div>
                <div class="auth-button">
                    <button type="submit" class="btn-submit" id="submitGantiPasswordAwal">Atur Kata Sandi</button>
                </div>
            </form>
        </div>
    </div>

    <div class="auth-image">
        <img src="{{ asset('img/ganti-pw.png') }}" alt="Ilustrasi Keamanan Login">
    </div>
</div>
@endsection
