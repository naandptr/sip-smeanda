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

    /**
     * Relasi ke DudiJurusan (Satu jurusan memiliki banyak DudiJurusan)
     */
    public function dudiJurusan()
    {
        return $this->hasMany(DudiJurusan::class, 'jurusan_id');
    }

    /**
     * Relasi ke Kelas (Satu jurusan memiliki banyak Kelas)
     */
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'jurusan_id');
    }

    /**
     * Relasi ke AdminJurusan (Satu jurusan memiliki satu AdminJurusan)
     */
    public function adminJurusan()
    {
        return $this->hasOne(AdminJurusan::class, 'jurusan_id');
    }
}
