<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjar extends Model
{
    protected $table = 'tbl_tahun_ajar';
    protected $fillable = ['tahun_ajaran', 'periode_mulai', 'periode_selesai', 'status'];

    // Scope untuk tahun aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'Aktif');
    }
}
