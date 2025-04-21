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
        'user_id', 
        'jurusan_id', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function dudiJurusan()
    {
        return $this->hasMany(DudiJurusan::class, 'jurusan_id', 'jurusan_id');
    }

    public function penetapanPrakerin()
    {
        return $this->hasManyThrough(
            PenetapanPrakerin::class, 
            DudiJurusan::class, 
            'jurusan_id', 
            'dudi_jurusan_id', 
            'jurusan_id', 
            'id' 
        );
    }
}
