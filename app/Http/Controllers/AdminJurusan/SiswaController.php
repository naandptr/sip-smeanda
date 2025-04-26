<?php

namespace App\Http\Controllers\AdminJurusan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\TahunAjar;

class SiswaController extends Controller
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

        $dataSiswa = Siswa::with([
                'kelas.jurusan',
                'penetapanPrakerin' => function ($q) {
                    $q->latest('tanggal_mulai');
                },
                'penetapanPrakerin.dudiJurusan.dudi',
                'penetapanPrakerin.dudiJurusan.pembimbing',
                'dokumen'
            ])
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

        foreach ($dataSiswa as $siswa) {
            $siswa->status_cv = $siswa->dokumen->where('jenis', 'CV')->isNotEmpty() ? 'selesai' : 'menunggu';
            $siswa->status_portofolio = $siswa->dokumen->where('jenis', 'Portofolio')->isNotEmpty() ? 'selesai' : 'menunggu';
            $siswa->status_laporan = $siswa->dokumen->where('jenis', 'Laporan')->isNotEmpty() ? 'selesai' : 'menunggu';
            $siswa->status_sertifikat = $siswa->dokumen->where('jenis', 'Sertifikat')->isNotEmpty() ? 'selesai' : 'menunggu';
        }

        return view('admin_jurusan.siswa', compact('dataSiswa', 'dataTahunAjaran', 'tahunAjaran'));
    }
}
