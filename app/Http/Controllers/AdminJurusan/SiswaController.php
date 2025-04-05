<?php

namespace App\Http\Controllers\AdminJurusan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;

class SiswaController extends Controller
{
    public function index()
    {
        $jurusanId = Auth::user()->adminJurusan->jurusan_id;

        $siswa = Siswa::with([
            'kelas.jurusan',
            'penetapanPrakerin' => function ($q) {
                $q->latest('tanggal_mulai');
            },
            'penetapanPrakerin.dudiJurusan.dudi',
            'penetapanPrakerin.dudiJurusan.pembimbing'
        ])
        ->whereHas('kelas', function ($q) use ($jurusanId) {
            $q->where('jurusan_id', $jurusanId);
        })
        ->get();

        return view('admin_jurusan.siswa', compact('siswa'));
    }
}
