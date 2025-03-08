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
                <h4>Sebelum masuk untuk akses, harap perbarui kata sandi!</h4>
            </div>
    
            <form action="/change-first-pass" method="POST" class="auth-form" id="changeFirstPassForm">
                <div class="auth-group">        
                    <div class="auth-field">
                        <label for="newPwFirst">Create Password</label>
                        <div class="pass-wrapper">
                            <input type="password" name="new-pw" id="newPwFirst" required>
                            <img src="{{ asset('img/hidden-icon.png') }}" class="toggle-password" data-target="newPwFirst" alt="Toggle Password">
                        </div>
                    </div>
                </div>
                <div class="auth-group">        
                    <div class="auth-field">
                        <label for="confirmPwFirst">Re-enter Password</label>
                        <div class="pass-wrapper">
                            <input type="password" name="confirm-pw" id="confirmPwFirst" required>
                            <img src="{{ asset('img/hidden-icon.png') }}" class="toggle-password" data-target="confirmPwFirst" alt="Toggle Password">
                        </div>
                    </div>
                </div>
                <div class="auth-button">
                    <button type="submit" class="btn-submit">Set Password</button>
                </div>
            </form>
        </div>
    </div>

    <div class="auth-image">
        <img src="{{ asset('img/ganti-pw.png') }}" alt="Ilustrasi Keamanan Login">
    </div>
</div>
@endsection
