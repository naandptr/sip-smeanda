<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pembimbing extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'tbl_pembimbing';

    protected $fillable = [
        'nip',
        'nama',
        'telp',
        'user_id', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function dudiJurusan()
    {
        return $this->hasMany(dudiJurusan::class, 'pembimbing_id', 'id');
    }
}
