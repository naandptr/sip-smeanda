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
        ->paginate(10);

        foreach ($dataSiswa as $siswa) {
            $siswa->status_cv = $siswa->dokumen->where('jenis', 'CV')->isNotEmpty() ? 'selesai' : 'menunggu';
            $siswa->status_portofolio = $siswa->dokumen->where('jenis', 'Portofolio')->isNotEmpty() ? 'selesai' : 'menunggu';
            $siswa->status_laporan = $siswa->dokumen->where('jenis', 'Laporan')->isNotEmpty() ? 'selesai' : 'menunggu';
            $siswa->status_sertifikat = $siswa->dokumen->where('jenis', 'Sertifikat')->isNotEmpty() ? 'selesai' : 'menunggu';
        }

        return view('admin_jurusan.siswa', compact('dataSiswa'));
    }
}
