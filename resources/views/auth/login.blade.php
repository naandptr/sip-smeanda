@php 
    $page_name = 'auth/login'; 
@endphp

@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="auth-container">
    <div class="auth-section">
        <div class="auth-brand">
            <img src="{{ asset('img/logo-icon.png') }}" height="49" alt="Logo SMKN 2" loading="lazy"/>
            <h5 class="brand-text">SISTEM INFORMASI PRAKERIN</h5>
        </div>  

        <div class="auth-body">
            <div class="auth-header">
                <h1>MASUK</h1>
                <h4>Masuk ke akunmu untuk mengakses kegiatan prakerin</h4>
            </div>

            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
    
            <form action="{{ route('login') }}" method="POST" class="auth-form" id="loginForm">
                @csrf
                <div class="auth-group">
                    <div class="auth-field">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
        
                    <div class="auth-field">
                        <label for="password">Password</label>
                        <div class="pass-wrapper">
                            <input type="password" name="password" id="password" required>
                            <img src="{{ asset('img/hidden-icon.png') }}" class="toggle-password" data-target="password" alt="Toggle Password">
                        </div>
                    </div>
                </div>
                <div class="auth-button">
                    <button type="submit" class="btn-submit" id="submitLogin">Login</button>
                    <a href="{{ route('lupa-password') }}" class="btn-lupa-pass">Lupa Kata Sandi?</a>
                </div>
            </form>
        </div>
    </div>

    <div class="auth-image">
        <img src="{{ asset('img/login.png') }}" alt="Ilustrasi Keamanan Login">
    </div>
</div>
@endsection
