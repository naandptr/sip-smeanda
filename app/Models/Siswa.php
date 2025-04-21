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
        'nis',
        'nama',
        'user_id', 
        'kelas_id', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public function jurusan()
    {
        return $this->hasOneThrough(
            Jurusan::class,
            Kelas::class,
            'id',       
            'id',     
            'kelas_id',  
            'jurusan_id' 
        );
    }

    public function penetapanPrakerin()
    {
        return $this->hasMany(PenetapanPrakerin::class, 'siswa_id', 'id');
    }

    public function penetapanPrakerinTerbaru()
    {
        return $this->hasOne(PenetapanPrakerin::class)->latest('tanggal_mulai');
    }

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class, 'siswa_id', 'id');
    }
}
