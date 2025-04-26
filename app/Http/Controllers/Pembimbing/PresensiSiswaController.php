<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Presensi;
use App\Models\TahunAjar;
use Illuminate\Support\Facades\Auth;

class PresensiSiswaController extends Controller
{
    public function index()
    {
        $pembimbingId = Auth::user()->pembimbing->id;

        $tahunAjaranAktif = TahunAjar::where('status', 'Aktif')->first();

        $tahunAjaran = request('tahun_ajaran', $tahunAjaranAktif ? $tahunAjaranAktif->tahun_ajaran : null);
        $status = request('status');

        $dataSiswaQuery = Siswa::with(['penetapanPrakerinTerbaru.dudiJurusan'])
            ->whereHas('penetapanPrakerinTerbaru.dudiJurusan', function ($query) use ($pembimbingId) {
                $query->where('pembimbing_id', $pembimbingId);
            });

        if ($tahunAjaran) {
            $tahunAjaranId = TahunAjar::where('tahun_ajaran', $tahunAjaran)->first()->id;

            $dataSiswaQuery->whereHas('penetapanPrakerinTerbaru', function ($query) use ($tahunAjaranId) {
                $query->where('tahun_ajar_id', $tahunAjaranId);
            });
        }

        if ($status) {
            $dataSiswaQuery->whereHas('penetapanPrakerinTerbaru', function ($query) use ($status) {
                $query->where('status', $status);
            });
        }

        $dataSiswa = $dataSiswaQuery->get();

        $currentPage = request()->get('page', 1);
        $perPage = 10;
        $paginatedSiswa = new \Illuminate\Pagination\LengthAwarePaginator(
            $dataSiswa->forPage($currentPage, $perPage),
            $dataSiswa->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $dataTahunAjaran = TahunAjar::pluck('tahun_ajaran');

        return view('guru.presensi', [
            'dataSiswa' => $paginatedSiswa,
            'dataTahunAjaran' => $dataTahunAjaran,
            'tahunAjaranAktif' => $tahunAjaranAktif->tahun_ajaran ?? null
        ]);
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

        $dataPresensi = Presensi::where('penetapan_prakerin_id', $penetapanId)
                  ->orderBy('tanggal', 'desc')
                  ->paginate(10);

        return view('guru.detail_presensi', compact('siswa', 'dataPresensi'));
    }
}
