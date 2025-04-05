<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenetapanPrakerin extends Model
{
    use HasFactory;

    protected $table = 'tbl_penetapan_prakerin';

    protected $fillable = [
        'siswa_id',
        'dudi_jurusan_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'tahun_ajar_id',
        'status'
    ];

    public function dudiJurusan()
    {
        return $this->belongsTo(DudiJurusan::class, 'dudi_jurusan_id');
    }

    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class, 'tahun_ajar_id');
    }
}
