<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ketidakhadiran extends Model
{
    use HasFactory;

    protected $table = 'tbl_ketidakhadiran';

    protected $fillable = [
        'penilaian_id',
        'sakit',
        'ijin',
        'tanpa_keterangan'
    ];

    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class, 'penilaian_id');
    }
}
