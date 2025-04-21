<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'tbl_jurusan'; 

    protected $fillable = [
        'nama_jurusan',
        'kode_jurusan',
        'status'
    ]; 

    public function dudiJurusan()
    {
        return $this->hasMany(DudiJurusan::class, 'jurusan_id');
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'jurusan_id');
    }

    public function adminJurusan()
    {
        return $this->hasOne(AdminJurusan::class, 'jurusan_id');
    }
}
