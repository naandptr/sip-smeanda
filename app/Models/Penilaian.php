<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'tbl_penilaian';

    protected $fillable = [
        'penetapan_prakerin_id',
        'nama_instruktur',
        'catatan'
    ];

    public function penetapanPrakerin()
    {
        return $this->belongsTo(PenetapanPrakerin::class, 'penetapan_prakerin_id');
    }

    public function penilaianDetail()
    {
        return $this->hasMany(PenilaianDetail::class, 'penilaian_id');
    }

    public function ketidakhadiran()
    {
        return $this->hasOne(Ketidakhadiran::class, 'penilaian_id');
    }
}
