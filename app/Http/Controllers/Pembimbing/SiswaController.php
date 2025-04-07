<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;

class SiswaController extends Controller
{
    public function index()
    {
        $pembimbingId = Auth::user()->pembimbing->id;

        $siswa = Siswa::with([
            'kelas.jurusan',
            'penetapanPrakerin' => function ($q) {
                $q->latest('tanggal_mulai');
            },
            'penetapanPrakerin.dudiJurusan.dudi',
            'penetapanPrakerin.dudiJurusan.pembimbing'
        ])
        ->whereHas('penetapanPrakerin.dudiJurusan', function ($q) use ($pembimbingId) {
            $q->where('pembimbing_id', $pembimbingId);
        })
        ->get();

        return view('guru.siswa', compact('siswa'));
    }
}
