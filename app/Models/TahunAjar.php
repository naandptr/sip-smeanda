<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjar extends Model
{
    protected $table = 'tbl_tahun_ajar';
    protected $fillable = ['tahun_ajaran', 'periode_mulai', 'periode_selesai', 'status'];

    public function scopeActive($query)
    {
        return $query->where('status', 'Aktif');
    }

    public function penetapanPrakerin()
    {
        return $this->hasMany(PenetapanPrakerin::class, 'tahun_ajar_id');
    }
}
