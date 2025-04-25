<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'tbl_presensi';

    protected $fillable = [
        'penetapan_prakerin_id', 
        'tanggal',
        'jenis_presensi',
        'status_kehadiran',
        'keterangan',
        'file',
        'presensi_datang_id' 
    ];

    public function penetapanPrakerin()
    {
        return $this->belongsTo(PenetapanPrakerin::class, 'penetapan_prakerin_id');
    }

    public function presensiDatang()
    {
        return $this->belongsTo(Presensi::class, 'presensi_datang_id');
    }
}
