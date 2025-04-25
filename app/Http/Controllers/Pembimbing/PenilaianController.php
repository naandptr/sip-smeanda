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
        $request->validate([
            'tujuan_pembelajaran' => 'required|string',
            'skor' => [
                'bail',
                'required',
                'regex:/^\d+(\.\d{1,2})?$/',
                'numeric',
                'gte:0',
            ],
            'deskripsi' => 'required|string',
        ], [
            'tujuan_pembelajaran.required' => 'Tujuan pembelajaran tidak boleh kosong',
            'skor.required' => 'Skor wajib diisi',
            'skor.regex' => 'Skor hanya menggunakan titik (.) sebagai pemisah desimal',
            'skor.numeric' => 'Skor harus berupa angka',
            'skor.gte' => 'Skor tidak boleh kurang dari 0',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong',
        ]);
              
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
            'catatan' => 'required|string',
        ],[
            'siswaBimbingan.required' => 'Siswa bimbingan harus dipilih',
            'namaInstruktur.required' => 'Nama instruktur harus diisi',
            'catatan.required' => 'Catatan harus diisi',
            'jumlahSakit.required' => 'Jumlah sakit harus diisi',
            'jumlahIjin.required' => 'Jumlah ijin harus diisi',
            'jumlahAlpa.required' => 'Jumlah alpa harus diisi',
            'jumlahSakit.integer' => 'Jumlah sakit harus berupa angka minimal 0',
            'jumlahIjin.integer' => 'Jumlah ijin harus berupa angka minimal 0',
            'jumlahAlpa.integer' => 'Jumlah alpa harus berupa angka minimal 0',
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

            if (empty($detailNilai)) {
                return response()->json([
                    'error' => 'Detail penilaian tidak boleh kosong. Harap tambahkan minimal satu tujuan pembelajaran.'
                ], 422);
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
