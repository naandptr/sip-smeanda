<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Siswa;


class InfoPrakerinController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $siswa = Siswa::with([
            'penetapanPrakerin.dudiJurusan.dudi',
            'penetapanPrakerin.dudiJurusan.pembimbing'
        ])->where('user_id', $user->id)->first();

        $penetapan = $siswa?->penetapanPrakerin?->sortByDesc('tanggal_mulai')?->first();

        return view('siswa.info_prakerin', compact('penetapan'));
    }
}
