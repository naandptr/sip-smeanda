<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Models\User; 
use App\Http\Controllers\AdminUtama;
use App\Http\Controllers\AdminJurusan;
use App\Http\Controllers\Pembimbing;
use App\Http\Controllers\Siswa;


Route::middleware(['web'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/lupa-password', [AuthController::class, 'showLupaPasswordForm'])->name('lupa-password');
    Route::post('/lupa-password', [ResetPasswordController::class, 'sendResetLink'])->name('password.email');

    // Ganti password awal 
    Route::get('/ganti-password-awal', [AuthController::class, 'changePasswordFormAwal'])->name('ganti-password-awal');
    Route::post('/ganti-password-awal', [AuthController::class, 'changePasswordAwal'])->name('ganti-password-awal.store');

    // Lupa Password
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password-form', [ResetPasswordController::class, 'resetPassword'])->name('password.update');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Email Verification Route
Route::get('/verify-account/{token}', [AuthController::class, 'verifyAccount'])->name('verify-account');

Route::middleware(['auth', 'account.status', 'check.default.password'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/setup-akun', [AuthController::class, 'showSetupForm'])->name('setup-akun');
    Route::post('/setup-akun', [AuthController::class, 'setupAccount']);

    Route::get('/akun', [AuthController::class, 'showAccount'])->name('akun.show');


    // Lupa password
    Route::get('/ganti-password', [AuthController::class, 'changePasswordForm'])->name('akun.show.ganti_password');
    Route::post('/ganti-password', [AuthController::class, 'changePassword'])->name('akun.ganti_password');
});

// Route untuk Admin Jurusan
Route::middleware(['auth', 'verified', 'role:'.User::ROLE_ADMIN_JURUSAN])->group(function () {
    Route::get('/siswa-jurusan', [AdminJurusan\SiswaController::class, 'index'])->name('jurusan.siswa');
    
    // Route Dokumen Siswa Jurusan
    Route::get('/dokumen-siswa', [AdminJurusan\DokumenController::class, 'index'])->name('jurusan.dokumen');
    Route::get('/dokumen-siswa/{id}/download', [AdminJurusan\DokumenController::class, 'download'])->name('dokumen-siswa.download');

    // Route CRUD Dudi Jurusan
    Route::get('/kelola-dudi-jurusan', [AdminJurusan\DudiJurusanController::class, 'index'])->name('jurusan.dudi-jurusan');
    Route::post('/kelola-dudi-jurusan', [AdminJurusan\DudiJurusanController::class, 'store'])->name('dudi-jurusan.store');
    Route::get('/kelola-dudi-jurusan/{id}/edit', [AdminJurusan\DudiJurusanController::class, 'edit'])->name('dudi-jurusan.edit');
    Route::patch('/kelola-dudi-jurusan/{id}/update', [AdminJurusan\DudiJurusanController::class, 'update'])->name('dudi-jurusan.update');
    Route::delete('/kelola-dudi-jurusan/{id}/delete', [AdminJurusan\DudiJurusanController::class, 'destroy'])->name('dudi-jurusan.destroy');

    // Route CRUD Prakerin
    Route::get('/kelola-prakerin', [AdminJurusan\PenetapanPrakerinController::class, 'index'])->name('jurusan.prakerin');
    Route::post('/kelola-prakerin', [AdminJurusan\PenetapanPrakerinController::class, 'store'])->name('prakerin.store');
    Route::get('/kelola-prakerin/{id}/edit', [AdminJurusan\PenetapanPrakerinController::class, 'edit'])->name('prakerin.edit');
    Route::patch('/kelola-prakerin/{id}/update', [AdminJurusan\PenetapanPrakerinController::class, 'update'])->name('prakerin.update');
    Route::delete('/kelola-prakerin/{id}/delete', [AdminJurusan\PenetapanPrakerinController::class, 'destroy'])->name('prakerin.destroy');

    Route::view('/akun-admin', 'admin_jurusan.akun')->name('jurusan.akun');
});

// Route untuk Guru Pembimbing
Route::middleware(['auth', 'verified', 'role:'.User::ROLE_GURU])->group(function () {
    Route::get('/siswa-bimbingan', [Pembimbing\SiswaController::class, 'index'])->name('guru.siswa');

    Route::get('/absen-siswa', [Pembimbing\AbsenSiswaController::class, 'index'])->name('guru.absen');
    Route::get('/absen-siswa/detail/{id}', [Pembimbing\AbsenSiswaController::class, 'detail'])->name('absen-detail.guru');

    Route::get('/jurnal-siswa', [Pembimbing\JurnalSiswaController::class, 'index'])->name('guru.jurnal');
    Route::get('/jurnal-siswa/{siswa}', [Pembimbing\JurnalSiswaController::class, 'detail'])->name('jurnal.detail');
    Route::post('/jurnal-validasi/{id}', [Pembimbing\JurnalSiswaController::class, 'validasi'])->name('validasi.store');

    Route::get('/penilaian', [Pembimbing\PenilaianController::class, 'index'])->name('guru.nilai');
    Route::get('/get-siswa-bimbingan/{id}', [Pembimbing\PenilaianController::class, 'getDataSiswa']);
    Route::get('/tambah_nilai', [Pembimbing\PenilaianController::class, 'showForm'])->name('nilai.form');
    Route::post('/tambah_nilai/detail/simpan', [Pembimbing\PenilaianController::class, 'simpanDetailNilaiSementara'])->name('nilai.detail.simpan');
    Route::delete('/tambah_nilai/detail/hapus/{index}', [Pembimbing\PenilaianController::class, 'hapusDetailNilaiSementara'])->name('nilai.detail.hapus');
    Route::post('/tambah_nilai/store', [Pembimbing\PenilaianController::class, 'store'])->name('nilai.store');
    Route::get('/penilaian/download/{id}', [Pembimbing\PenilaianController::class, 'downloadPenilaianPDF'])->name('nilai.download');


    Route::view('/akun-guru', 'guru.akun')->name('guru.akun');
});
    
// Route untuk Siswa
Route::middleware(['auth', 'verified', 'role:'.User::ROLE_SISWA])->group(function () {
    Route::get('/info-prakerin', [Siswa\InfoPrakerinController::class, 'index'])->name('siswa.info');

    Route::get('/dokumen-prakerin', [Siswa\DokumenController::class, 'index'])->name('siswa.dokumen');
    Route::post('/dokumen-prakerin/upload/{jenis}', [Siswa\DokumenController::class, 'upload'])->name('dokumen.upload');
    Route::get('/dokumen/download/{id}', [Siswa\DokumenController::class, 'download'])->name('dokumen.download');

    Route::get('/absen-prakerin', [Siswa\AbsenController::class, 'index'])->name('siswa.absen');
    Route::post('/absen-prakerin', [Siswa\AbsenController::class, 'store'])->name('absen.store');

    Route::view('/jurnal-prakerin', 'siswa.jurnal')->name('siswa.jurnal');
    Route::get('/jurnal-prakerin', [Siswa\JurnalController::class, 'index'])->name('siswa.jurnal');
    Route::post('/jurnal-prakerin', [Siswa\JurnalController::class, 'store'])->name('jurnal.store');
    Route::post('/upload-image-jurnal', [Siswa\JurnalController::class, 'uploadImage'])->name('jurnal.upload-image');;

    Route::delete('/jurnal-prakerin/{id}/delete', [Siswa\JurnalController::class, 'destroy'])->name('jurnal.destroy');

    Route::view('/akun-siswa', 'siswa.nilai')->name('siswa.akun');
});

// Route untuk Admin Utama
Route::middleware(['auth', 'role:'.User::ROLE_ADMIN_UTAMA])->group(function () {
    // Route CRUD User
    Route::get('/kelola-user', [AdminUtama\UserController::class, 'index'])->name('admin.user');
    Route::post('/kelola-user', [AdminUtama\UserController::class, 'store'])->name('user.store');
    Route::get('/kelola-user/{id}/edit', [AdminUtama\UserController::class, 'edit'])->name('user.edit');
    Route::patch('/kelola-user/{id}/update', [AdminUtama\UserController::class, 'update'])->name('user.update');
    Route::delete('/kelola-user/{id}/delete', [AdminUtama\UserController::class, 'destroy'])->name('user.destroy');
            
    // Route CRUD Tahun Ajaran 
    Route::get('/kelola-tahun-ajar', [AdminUtama\TahunAjarController::class, 'index'])->name('admin.tahun-ajar');
    Route::post('/kelola-tahun-ajar', [AdminUtama\TahunAjarController::class, 'store'])->name('tahun-ajar.store');
    Route::get('/kelola-tahun-ajar/{id}/edit', [AdminUtama\TahunAjarController::class, 'edit'])->name('tahun-ajar.edit');
    Route::patch('/kelola-tahun-ajar/{id}/update', [AdminUtama\TahunAjarController::class, 'update'])->name('tahun-ajar.update');
    Route::delete('/kelola-tahun-ajar/{id}/delete', [AdminUtama\TahunAjarController::class, 'destroy'])->name('tahun-ajar.destroy');
    Route::patch('/kelola-tahun-ajar/{id}/toggle-status', [AdminUtama\TahunAjarController::class, 'toggleStatus'])->name('tahun-ajar.toggle-status');

    // Route CRUD Jurusan
    Route::get('/kelola-jurusan', [AdminUtama\JurusanController::class, 'index'])->name('admin.jurusan');
    Route::post('/kelola-jurusan', [AdminUtama\JurusanController::class, 'store'])->name('jurusan.store');
    Route::get('/kelola-jurusan/{id}/edit', [AdminUtama\JurusanController::class, 'edit'])->name('jurusan.edit');
    Route::patch('/kelola-jurusan/{id}/update', [AdminUtama\JurusanController::class, 'update'])->name('jurusan.update');
    Route::delete('/kelola-jurusan/{id}/delete', [AdminUtama\JurusanController::class, 'destroy'])->name('jurusan.destroy');

    // Route CRUD Kelas
    Route::get('/kelola-kelas', [AdminUtama\KelasController::class, 'index'])->name('admin.kelas');
    Route::post('/kelola-kelas', [AdminUtama\KelasController::class, 'store'])->name('kelas.store');
    Route::get('/kelola-kelas/{id}/edit', [AdminUtama\KelasController::class, 'edit'])->name('kelas.edit');
    Route::patch('/kelola-kelas/{id}/update', [AdminUtama\KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelola-kelas/{id}/delete', [AdminUtama\KelasController::class, 'destroy'])->name('kelas.destroy');

    // Route CRUD Lokasi
    Route::get('/kelola-lokasi', [AdminUtama\DudiController::class, 'index'])->name('admin.lokasi');
    Route::post('/kelola-lokasi', [AdminUtama\DudiController::class, 'store'])->name('lokasi.store');
    Route::get('/kelola-lokasi/{id}/edit', [AdminUtama\DudiController::class, 'edit'])->name('lokasi.edit');
    Route::patch('/kelola-lokasi/{id}/update', [AdminUtama\DudiController::class, 'update'])->name('lokasi.update');
    Route::delete('/kelola-lokasi/{id}/delete', [AdminUtama\DudiController::class, 'destroy'])->name('lokasi.destroy');
});


// Fallback route
Route::fallback(function () {
    return Auth::check() 
        ? redirect()->route('dashboard') 
        : redirect()->route('login');
});
