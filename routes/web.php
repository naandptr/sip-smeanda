<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
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
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Email Verification Route
Route::get('/verify-account/{token}', [AuthController::class, 'verifyAccount'])->name('verify-account');

// // Dashboard
// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'verified']);

Route::middleware(['auth', 'account.status'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/setup-akun', [AuthController::class, 'showSetupForm'])->name('setup-akun');
    Route::post('/setup-akun', [AuthController::class, 'setupAccount']);
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

// Route untuk Guru
Route::middleware(['auth', 'verified', 'role:'.User::ROLE_GURU])->group(function () {
    Route::get('/siswa-bimbingan', [Pembimbing\SiswaController::class, 'index'])->name('guru.siswa');
    Route::view('/absen-siswa', 'guru.absen')->name('guru.absen');
    Route::view('/jurnal-siswa', 'guru.jurnal')->name('guru.jurnal');
    Route::view('/nilai-siswa', 'guru.nilai')->name('guru.nilai');
    Route::view('/akun-guru', 'guru.akun')->name('guru.akun');
});
    
// Route untuk Siswa
Route::middleware(['auth', 'verified', 'role:'.User::ROLE_SISWA])->group(function () {
    Route::get('/info-prakerin', [Siswa\InfoPrakerinController::class, 'index'])->name('siswa.info');

    Route::get('/dokumen-prakerin', [Siswa\DokumenController::class, 'index'])->name('siswa.dokumen');
    Route::post('/dokumen-prakerin/upload/{jenis}', [Siswa\DokumenController::class, 'upload'])->name('dokumen.upload');
    Route::get('/dokumen/download/{id}', [Siswa\DokumenController::class, 'download'])->name('dokumen.download');


    Route::view('/absen-prakerin', 'siswa.absen')->name('siswa.absen');
    Route::view('/jurnal-prakerin', 'siswa.jurnal')->name('siswa.jurnal');
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
