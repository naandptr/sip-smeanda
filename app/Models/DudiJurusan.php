<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DudiJurusan extends Model
{
    use HasFactory;

    protected $table = 'tbl_dudi_jurusan';

    protected $fillable = [
        'dudi_id',
        'jurusan_id',
        'tahun_ajar_id',
        'pembimbing_id'
    ];

    public function dudi()
    {
        return $this->belongsTo(Dudi::class, 'dudi_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class, 'tahun_ajar_id');
    }

    public function pembimbing()
    {
        return $this->belongsTo(Pembimbing::class, 'pembimbing_id');
    }

    public function penetapanPrakerin()
    {
        return $this->hasMany(PenetapanPrakerin::class, 'dudi_jurusan_id');
    }

    public function siswa()
    {
        return $this->hasManyThrough(
            Siswa::class,
            PenetapanPrakerin::class,
            'dudi_jurusan_id', // Foreign key di PenetapanPrakerin menuju DudiJurusan
            'id', // Primary key di Siswa
            'id', // Primary key di DudiJurusan
            'siswa_id' // Foreign key di PenetapanPrakerin menuju Siswa
        );
    }

}
