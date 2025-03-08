<?php

use Illuminate\Support\Facades\Route;

// Halaman Login
Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/change_pass', function () {
    return view('auth.change_pass');
});

// Redirect default ke halaman sesuai role 
Route::get('/', function () {
    $role = request()->get('role', 'siswa');

    if ($role == 'guru') {
        return view('guru/home');
    } elseif ($role == 'admin_jurusan') {
        return view('admin_jurusan/home');
    } elseif ($role == 'admin_utama') {
        return view('admin_utama/home');
    }

    return view('siswa/home'); // Default siswa
});

// Group untuk Siswa
Route::prefix('siswa')->group(function () {
    Route::view('/info', 'siswa/info_prakerin');
    Route::view('/dokumen', 'siswa/dokumen');
    Route::view('/absen', 'siswa/absen');
    Route::view('/jurnal', 'siswa/jurnal');
    Route::view('/nilai', 'siswa/nilai');
    Route::view('/akun', 'siswa/akun');
    Route::view('/change_pass', 'siswa/change_pass');
});

// Group untuk Guru
Route::prefix('guru')->group(function () {
    Route::view('/dashboard', 'guru/dashboard');
    Route::view('/siswa', 'guru/siswa');
    Route::view('/absen', 'guru/absen');
    Route::view('/jurnal', 'guru/jurnal');
    Route::view('/akun', 'guru/akun');
    Route::view('/change_pass', 'guru/change_pass');
});

// Group untuk Admin Jurusan
Route::prefix('admin_jurusan')->group(function () {
    Route::view('/dashboard', 'admin_jurusan/dashboard');
    Route::view('/siswa', 'admin_jurusan/siswa');
    Route::view('/lokasi', 'admin_jurusan/lokasi');
    Route::view('/dokumen', 'admin_jurusan/dokumen');
    Route::view('/penetapan', 'admin_jurusan/penetapan');
    Route::view('/nilai', 'admin_jurusan/nilai');
    Route::view('/akun', 'admin_jurusan/akun');
    Route::view('/change_pass', 'admin_jurusan/change_pass');
});

// Group untuk Admin Utama
Route::prefix('admin_utama')->group(function () {
    Route::view('/dashboard', 'admin_utama/dashboard');
    Route::view('/user', 'admin_utama/user');
    Route::view('/jurusan', 'admin_utama/jurusan');
    Route::view('/kelas', 'admin_utama/kelas');
    Route::view('/tahun_ajar', 'admin_utama/tahun_ajar');
});



