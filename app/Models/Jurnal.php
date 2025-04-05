<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;

    protected $table = 'tbl_jurnal';

    protected $fillable = [
        'penetapan_prakerin_id',
        'tanggal',
        'deskripsi',
    ];

    public function penetapanPrakerin()
    {
        return $this->belongsTo(PenetapanPrakerin::class, 'penetapan_prakerin_id');
    }

    public function validasi()
    {
        return $this->hasOne(Validasi::class, 'jurnal_id');
    }
}
