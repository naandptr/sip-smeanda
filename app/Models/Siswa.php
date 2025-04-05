<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Siswa extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'tbl_siswa';

    protected $fillable = [
        'nisn',
        'nama',
        'user_id', // Foreign key ke tabel users
        'kelas_id', // Foreign key ke tabel kelas
    ];

    // Siswa memiliki akun user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Siswa berada dalam satu kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    // Siswa bisa mengakses jurusannya melalui kelas
    public function jurusan()
    {
        return $this->hasOneThrough(
            Jurusan::class,
            Kelas::class,
            'id',        // Foreign key di Kelas yang mengarah ke Jurusan
            'id',        // Primary key di Jurusan
            'kelas_id',  // Foreign key di Siswa yang mengarah ke Kelas
            'jurusan_id' // Foreign key di Kelas yang mengarah ke Jurusan
        );
    }

    // Siswa bisa memiliki lebih dari satu penetapan prakerin
    public function penetapanPrakerin()
    {
        return $this->hasMany(PenetapanPrakerin::class, 'siswa_id', 'id');
    }

    // Siswa bisa memiliki lebih dari satu dokumen
    public function dokumen()
    {
        return $this->hasMany(Dokumen::class, 'siswa_id', 'id');
    }
}
