<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AdminJurusan extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'tbl_admin_jurusan'; 

    protected $fillable = [
        'nama',
        'user_id', // Foreign key ke tabel users
        'jurusan_id', // Foreign key ke tabel jurusan
    ];


    // AdminJurusan dimiliki satu user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // AdminJurusan berada di satu jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    // Relasi ke DudiJurusan, karena admin jurusan mengelola DUDI jurusan
    public function dudiJurusan()
    {
        return $this->hasMany(DudiJurusan::class, 'jurusan_id', 'jurusan_id');
    }

    // Relasi ke PenetapanPrakerin, karena admin jurusan mengelola penetapan prakerin
    public function penetapanPrakerin()
    {
        return $this->hasManyThrough(
            PenetapanPrakerin::class, 
            DudiJurusan::class, 
            'jurusan_id',  // Foreign key di DudiJurusan yang merujuk ke Jurusan
            'dudi_jurusan_id', // Foreign key di PenetapanPrakerin yang merujuk ke DudiJurusan
            'jurusan_id', // Local key di AdminJurusan
            'id' // Local key di DudiJurusan
        );
    }
}
