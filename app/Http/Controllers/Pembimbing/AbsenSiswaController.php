<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Absen;
use Illuminate\Support\Facades\Auth;

class AbsenSiswaController extends Controller
{
    public function index()
    {
        $pembimbingId = Auth::user()->pembimbing->id;

        $siswaBimbingan = Siswa::with(['penetapanPrakerinTerbaru.dudiJurusan'])->get()->filter(function ($siswa) use ($pembimbingId) {
            $penetapanTerbaru = $siswa->penetapanPrakerinTerbaru;
            return $penetapanTerbaru &&
                   $penetapanTerbaru->dudiJurusan &&
                   $penetapanTerbaru->dudiJurusan->pembimbing_id == $pembimbingId;
        });

        return view('guru.absen', compact('siswaBimbingan'));
    }

    public function detail($siswa_id)
    {
        $siswa = Siswa::with(['penetapanPrakerinTerbaru.dudiJurusan'])->findOrFail($siswa_id);

        $pembimbingId = Auth::user()->pembimbing->id;

        $isBimbingan = optional(optional($siswa->penetapanPrakerinTerbaru)->dudiJurusan)->pembimbing_id === $pembimbingId;

        if (!$isBimbingan) {
            abort(403, 'Akses ditolak');
        }

        $penetapanId = $siswa->penetapanPrakerinTerbaru->id ?? null;

        $absenList = Absen::where('penetapan_prakerin_id', $penetapanId)->get();

        return view('guru.detail_absen', compact('siswa', 'absenList'));
    }
}
