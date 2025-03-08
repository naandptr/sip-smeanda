@extends('layouts.app')

@section('title', 'Ganti Password')

@section('content')
<div class="akun">
    <div class="header">
        <h1>Akun</h1>
    </div>
    <div class="pass-container">
        <div>
            <h1>Perbarui Kata Sandi</h1>
        </div>
        <form action="/change_pass" method="POST" class="change-pass-form" id="changePassForm">
            <div class="pass-group">
                <div class="pass-item">
                    <label for="oldPw">Password lama</label>
                    <div class="pass-wrapper">
                        <input type="password" name="old-pw" id="oldPw" required>
                        <img src="{{ asset('img/hidden-icon.png') }}" class="toggle-password" data-target="oldPw" alt="Toggle Password">
                    </div>
                </div>
                <div class="pass-item">
                    <label for="newPw">Password baru</label>
                    <div class="pass-wrapper">
                        <input type="password" name="new-pw" id="newPw" required>
                        <img src="{{ asset('img/hidden-icon.png') }}" class="toggle-password" data-target="newPw" alt="Toggle Password">
                    </div>
                </div>
                <div class="pass-item">
                    <label for="confirmPw">Konfirmasi password baru</label>
                    <div class="pass-wrapper">
                        <input type="password" name="confirm-pw" id="confirmPw" required>
                        <img src="{{ asset('img/hidden-icon.png') }}" class="toggle-password" data-target="confirmPw" alt="Toggle Password">
                    </div>
                </div>            
                <div class="pass-button">
                    <button type="submit" class="btn-submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
