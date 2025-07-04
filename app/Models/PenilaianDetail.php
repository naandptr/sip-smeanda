<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianDetail extends Model
{
    use HasFactory;

    protected $table = 'tbl_penilaian_detail';

    protected $fillable = [
        'penilaian_id',
        'tujuan_pembelajaran',
        'skor',
        'deskripsi'
    ];

    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class, 'penilaian_id');
    }
}
