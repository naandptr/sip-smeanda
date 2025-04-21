<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\PenilaianDetail;
use App\Models\Ketidakhadiran;
use App\Models\Siswa;
use App\Models\DudiJurusan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\PDF;

class PenilaianController extends Controller
{
    public function index()
    {
        $pembimbing = Auth::user()->pembimbing->id;

        $dudiJurusan = DudiJurusan::where('pembimbing_id', $pembimbing)
            ->pluck('id');

        $siswaQuery = Siswa::whereHas('penetapanPrakerinTerbaru', function ($query) use ($dudiJurusan) {
                $query->whereIn('dudi_jurusan_id', $dudiJurusan);
            })
            ->whereHas('penetapanPrakerinTerbaru.penilaian') 
            ->with(['kelas', 'penetapanPrakerinTerbaru.penilaian']);
        
        $dataSiswa = $siswaQuery->paginate(10);

            foreach ($dataSiswa as $siswa) {
                $siswa->penilaian = $siswa->penetapanPrakerinTerbaru->penilaian->first() ?? null;
            }

        return view('guru.nilai', compact('dataSiswa'));
    }

    public function showForm()
    {
        
        $pembimbing = Auth::user()->pembimbing->id;

        $dataSiswa = Siswa::whereHas('penetapanPrakerinTerbaru.dudiJurusan', function ($query) use ($pembimbing) {
            $query->where('pembimbing_id', $pembimbing);
        })->get();

        return view('guru.tambah_nilai', [
            'dataSiswa' => $dataSiswa,
            'detailNilaiSementara' => session('penilaian_detail', []),
        ]);        
    }

    public function getDataSiswa($id)
    {
        $siswa = Siswa::with([
            'kelas.jurusan',
            'penetapanPrakerinTerbaru.dudiJurusan.dudi',
            'penetapanPrakerinTerbaru.dudiJurusan.pembimbing'
        ])->findOrFail($id);

        return response()->json([
            'nis' => $siswa->nis,
            'kelas' => $siswa->kelas->nama_kelas ?? '-',
            'program_keahlian' => $siswa->kelas->jurusan->nama_jurusan ?? '-',
            'konsentrasi_keahlian' => $siswa->kelas->jurusan->nama_jurusan ?? '-',
            'tempat_pkl' => $siswa->penetapanPrakerinTerbaru?->dudiJurusan->dudi->nama_dudi ?? '-',
            'tanggal_pkl' => $siswa->penetapanPrakerinTerbaru?->tanggal_mulai . ' s.d ' . $siswa->penetapanPrakerinTerbaru?->tanggal_selesai,
            'nama_pembimbing' => $siswa->penetapanPrakerinTerbaru?->dudiJurusan?->pembimbing->nama ?? '-',
        ]);
    }

    public function simpanDetailNilaiSementara(Request $request)
    {
        $data = $request->only(['tujuan_pembelajaran', 'skor', 'deskripsi']);

        $detailNilai = session()->get('penilaian_detail', []);
        $detailNilai[] = $data;

        session(['penilaian_detail' => $detailNilai]);

        return response()->json(['success' => true, 'data' => $detailNilai]);
    }

    public function hapusDetailNilaiSementara($index)
    {
        $details = session()->get('penilaian_detail', []);

        if (isset($details[$index])) {
            unset($details[$index]);
            $details = array_values($details); 
            session(['penilaian_detail' => $details]);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Index tidak ditemukan']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswaBimbingan' => 'required|exists:tbl_siswa,id',
            'namaInstruktur' => 'required|string|max:255',
            'jumlahSakit' => 'required|integer|min:0',
            'jumlahIjin' => 'required|integer|min:0',
            'jumlahAlpa' => 'required|integer|min:0',
        ]);

        try {
            DB::beginTransaction();

            $siswa = Siswa::findOrFail($request->siswaBimbingan);
            $penetapan = $siswa->penetapanPrakerinTerbaru;

            if (!$penetapan) {
                return back()->withErrors(['siswaBimbingan' => 'Penetapan prakerin siswa tidak ditemukan.']);
            }

            $existingPenilaian = Penilaian::where('penetapan_prakerin_id', $penetapan->id)
            ->exists();
        

            if ($existingPenilaian) {
            return response()->json(['error' => 'Penilaian untuk siswa ini dengan penetapan prakerin yang sama sudah ada.'], 400);
            }

            $penilaian = Penilaian::create([
                'penetapan_prakerin_id' => $penetapan->id,
                'nama_instruktur' => $request->namaInstruktur,
                'catatan' => $request->catatan,
            ]);

            $detailNilai = session()->get('penilaian_detail', []);

            foreach ($detailNilai as $detail) {
                $penilaian->penilaianDetail()->create([
                    'tujuan_pembelajaran' => $detail['tujuan_pembelajaran'],
                    'skor' => $detail['skor'],
                    'deskripsi' => $detail['deskripsi'],
                ]);
            }

            Ketidakhadiran::create([
                'penilaian_id' => $penilaian->id,
                'sakit' => $request->jumlahSakit,
                'ijin' => $request->jumlahIjin,
                'tanpa_keterangan' => $request->jumlahAlpa,
            ]);

            DB::commit();

            session()->forget('penilaian_detail');

            return response()->json([
                'success' => 'Penilaian berhasil disimpan',
                'redirect_to' => route('guru.nilai')
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()], 500);
        }
    }

    public function downloadPenilaianPDF($id)
    {
        $penilaian = Penilaian::with(['penilaianDetail', 'ketidakhadiran', 'penetapanPrakerin.siswa', 'penetapanPrakerin.dudiJurusan.dudi'])
            ->findOrFail($id);

        $siswa = $penilaian->penetapanPrakerin->siswa;
        $dudi = $penilaian->penetapanPrakerin->dudiJurusan->dudi;
        $penilaianDetail = $penilaian->penilaianDetail;
        $ketidakhadiran = $penilaian->ketidakhadiran;

  
        $pdf = app('dompdf.wrapper');

        $pdf->loadView('guru.penilaian_pdf', compact('penilaian', 'siswa', 'dudi', 'penilaianDetail', 'ketidakhadiran'));

        return $pdf->download('nilai_' . $siswa->nama . '_' . $siswa->nis . '_' . $dudi->nama_dudi .  '.pdf');
    }
}
