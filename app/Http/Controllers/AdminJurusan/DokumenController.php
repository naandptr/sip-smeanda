<?php

namespace App\Http\Controllers\AdminJurusan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Dokumen;
use App\Models\TahunAjar;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function index(Request $request)
    {
        $jurusanId = Auth::user()->adminJurusan->jurusan_id;

        $dataTahunAjaran = TahunAjar::orderBy('tahun_ajaran', 'desc')->get(); 

        $tahunAjaranAktif = Siswa::whereHas('kelas', function($query) use ($jurusanId) {
            $query->where('jurusan_id', $jurusanId);
        })
        ->with('kelas')
        ->first(); 

        $tahunAjaran = $tahunAjaranAktif ? $tahunAjaranAktif->kelas->tahunAjar->id : null;

        $dataSiswa = Siswa::with(['dokumen', 'kelas.jurusan'])
            ->whereHas('kelas', function ($q) use ($jurusanId) {
                $q->where('jurusan_id', $jurusanId);
            })
            ->when($request->tahun_ajaran, function ($query) use ($request) {
                $query->whereHas('kelas', function ($q) use ($request) {
                    $q->where('tahun_ajar_id', $request->tahun_ajaran);
                });
            }, function($query) use ($tahunAjaran) {
                if ($tahunAjaran) {
                    $query->whereHas('kelas', function($q) use ($tahunAjaran) {
                        $q->where('tahun_ajar_id', $tahunAjaran);
                    });
                }
            })
            ->paginate(10);

        return view('admin_jurusan.dokumen', compact('dataSiswa', 'dataTahunAjaran', 'tahunAjaran'));
    }

    public function download($id)
    {
        $dokumen = Dokumen::with('siswa.kelas')->findOrFail($id);

        $jurusanId = Auth::user()->adminJurusan->jurusan_id;

        if (!$dokumen->siswa || !$dokumen->siswa->kelas || $dokumen->siswa->kelas->jurusan_id !== $jurusanId) {
            abort(403, 'Unauthorized');
        }

        $filePath = Storage::disk('public')->path($dokumen->file);

        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->download($filePath);
    }
}
