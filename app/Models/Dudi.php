<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dudi extends Model
{
    use HasFactory;

    protected $table = 'tbl_dudi';

    protected $fillable = [
        'nama_dudi',
        'alamat',
        'bidang_usaha',
        'telp',
        'email',
    ];

    public function dudiJurusan()
    {
        return $this->hasMany(DudiJurusan::class, 'dudi_id');
    }
}
