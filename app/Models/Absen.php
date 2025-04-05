<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;

    protected $table = 'tbl_absen';

    protected $fillable = [
        'penetapan_prakerin_id', // Foreign key ke tabel penetapan prakerin
        'tanggal',
        'jenis_absen',
        'status_kehadiran',
        'keterangan',
        'file',
        'absen_datang_id' // Foreign key ke tabel absen
    ];

    public function penetapanPrakerin()
    {
        return $this->belongsTo(PenetapanPrakerin::class, 'penetapan_prakerin_id');
    }

    public function absenDatang()
    {
        return $this->belongsTo(Absen::class, 'absen_datang_id');
    }
}
