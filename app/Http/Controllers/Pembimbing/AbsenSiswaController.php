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

        $dataSiswa = Siswa::with(['penetapanPrakerinTerbaru.dudiJurusan'])->get()->filter(function ($siswa) use ($pembimbingId) {
            $penetapanTerbaru = $siswa->penetapanPrakerinTerbaru;
            return $penetapanTerbaru &&
                   $penetapanTerbaru->dudiJurusan &&
                   $penetapanTerbaru->dudiJurusan->pembimbing_id == $pembimbingId;
        })->values();

        $currentPage = request()->get('page', 1);
        $perPage = 10;
        $paginatedSiswa = new \Illuminate\Pagination\LengthAwarePaginator(
            $dataSiswa->forPage($currentPage, $perPage),
            $dataSiswa->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('guru.absen', ['dataSiswa' => $paginatedSiswa]);
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

        $dataAbsen = Absen::where('penetapan_prakerin_id', $penetapanId)
                  ->orderBy('tanggal', 'desc')
                  ->paginate(10);

        return view('guru.detail_absen', compact('siswa', 'dataAbsen'));
    }
}
