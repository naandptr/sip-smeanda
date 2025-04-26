<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Jurnal;
use App\Models\Validasi;
use App\Models\TahunAjar;
use Illuminate\Support\Facades\Auth;

class JurnalSiswaController extends Controller
{
    public function index()
    {
        $pembimbingId = Auth::user()->pembimbing->id;
        $tahunAjaranAktif = TahunAjar::where('status', 'Aktif')->first();
        $tahunAjaranFilter = request('tahun_ajaran');  
        $statusFilter = request('status'); 

        $dataTahunAjaran = TahunAjar::pluck('tahun_ajaran', 'id');

        if (!$tahunAjaranFilter && $tahunAjaranAktif) {
            $tahunAjaranFilter = $tahunAjaranAktif->tahun_ajaran;
        }

        $dataSiswaQuery = Siswa::with(['penetapanPrakerinTerbaru.dudiJurusan', 'kelas', 'penetapanPrakerinTerbaru.tahunAjar'])
            ->whereHas('penetapanPrakerinTerbaru.dudiJurusan', function ($query) use ($pembimbingId) {
                $query->where('pembimbing_id', $pembimbingId);
            });

        if ($tahunAjaranFilter) {
            $tahunAjaranId = TahunAjar::where('tahun_ajaran', $tahunAjaranFilter)->first()->id;

            $dataSiswaQuery->whereHas('penetapanPrakerinTerbaru', function ($query) use ($tahunAjaranId) {
                $query->where('tahun_ajar_id', $tahunAjaranId);
            });
        }

        if ($statusFilter) {
            $dataSiswaQuery->whereHas('penetapanPrakerinTerbaru', function ($query) use ($statusFilter) {
                $query->where('status', $statusFilter);
            });
        }

        $dataSiswa = $dataSiswaQuery->get();

        $dataSiswaProcessed = $dataSiswa->map(function ($siswa) {
            $penetapan = $siswa->penetapanPrakerinTerbaru;

            $jurnalTerkirim = $penetapan->jurnal()->count();
            $jurnalValid = $penetapan->jurnal()
                ->whereHas('validasi', fn ($q) => $q->where('status_validasi', 'selesai'))
                ->count();

            return [
                'siswa' => $siswa,
                'penetapan_id' => $penetapan->id,
                'kelas' => $siswa->kelas->nama_kelas ?? '-',
                'jurnal_terkirim' => $jurnalTerkirim,
                'jurnal_validasi' => $jurnalValid,
            ];
        });

        $currentPage = request()->get('page', 1);
        $perPage = 10;
        $paginatedSiswa = new \Illuminate\Pagination\LengthAwarePaginator(
            $dataSiswaProcessed->forPage($currentPage, $perPage),
            $dataSiswaProcessed->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('guru.jurnal', [
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

    $penetapan = $siswa->penetapanPrakerinTerbaru;

    if ($penetapan) {
        $query = $penetapan->jurnal()->with('validasi');

        // cek apakah ada filter status dari request
        if (request('status')) {
            $query->whereHas('validasi', function ($q) {
                $q->where('status_validasi', request('status'));
            });
        }

        $dataJurnal = $query->paginate(10);
    } else {
        $dataJurnal = collect();
    }

    return view('guru.detail_jurnal', compact('siswa', 'dataJurnal'));
}


    public function validasi(Request $request, $id)
    { 

        $request->validate([
            'catatan' => 'required|string',
        ],[
            'catatan.required' => 'Catatan pembimbing harus diisi',
        ]);

        $existing = Validasi::where('jurnal_id', $id)
        ->where('status_validasi', 'Selesai')
        ->first();

        if ($existing) {
            return response()->json([
            'success' => false,
            'message' => 'Jurnal ini sudah divalidasi dan tidak bisa diubah lagi.'
            ], 403); 
        }

        $validasi = Validasi::firstOrNew([
            'jurnal_id' => $id, 
        ]);

        $validasi->catatan = $request->catatan;
        $validasi->status_validasi = 'Selesai';
        $validasi->save();

        return response()->json(['success' => true, 'message' => 'Jurnal berhasil divalidasi']);
    }
}
