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
            'penetapanPrakerin.dudiJurusan.pembimbing',
            'dokumen'
        ])
        ->whereHas('kelas', function ($q) use ($jurusanId) {
            $q->where('jurusan_id', $jurusanId);
        })
        ->get();

        foreach ($siswa as $s) {
            $s->status_cv = $s->dokumen->where('jenis', 'CV')->isNotEmpty() ? 'selesai' : 'menunggu';
            $s->status_portofolio = $s->dokumen->where('jenis', 'Portofolio')->isNotEmpty() ? 'selesai' : 'menunggu';
            $s->status_laporan = $s->dokumen->where('jenis', 'Laporan')->isNotEmpty() ? 'selesai' : 'menunggu';
            $s->status_sertifikat = $s->dokumen->where('jenis', 'Sertifikat')->isNotEmpty() ? 'selesai' : 'menunggu';
        }

        return view('admin_jurusan.siswa', compact('siswa'));
    }
}
