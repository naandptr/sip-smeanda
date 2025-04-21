<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\TahunAjar;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $pembimbingId = Auth::user()->pembimbing->id;

        $tahunAjaran = $request->input('tahun_ajaran');
    	$status = $request->input('status');

        $dataTahunAjaran = TahunAjar::orderBy('tahun_ajaran', 'desc')->pluck('tahun_ajaran');

        $dataSiswa = Siswa::with([
            'kelas.jurusan',
            'penetapanPrakerin' => function ($q) {
                $q->latest('tanggal_mulai');
            },
            'penetapanPrakerin.dudiJurusan.dudi',
            'penetapanPrakerin.dudiJurusan.pembimbing',
            'penetapanPrakerin.tahunAjar'
        ])
        ->whereHas('penetapanPrakerin.dudiJurusan', function ($q) use ($pembimbingId) {
            $q->where('pembimbing_id', $pembimbingId);
        })
        ->when($tahunAjaran, function ($query) use ($tahunAjaran) {
            $query->whereHas('penetapanPrakerin.tahunAjar', function ($q) use ($tahunAjaran) {
                $q->where('tahun_ajaran', $tahunAjaran);
            });
        })
        ->when($status, function ($query) use ($status) {
            $query->whereHas('penetapanPrakerin', function ($q) use ($status) {
                $q->where('status', $status);
            });
        })
        ->paginate(10);
        

        return view('guru.siswa', compact('dataSiswa', 'dataTahunAjaran'));
    }
}
