<?php

namespace App\Http\Controllers\AdminJurusan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\PenetapanPrakerin;
use App\Models\Siswa;
use App\Models\DudiJurusan;
use App\Models\TahunAjar;


class PenetapanPrakerinController extends Controller
{
    public function index(Request $request)
    {
        $jurusanId = Auth::user()->adminJurusan->jurusan_id;

        $tahunAjarAktif = TahunAjar::where('status', 'Aktif')->first();

        if (!$tahunAjarAktif) {
            return back()->with('error', 'Tidak ada tahun ajaran aktif yang ditemukan.');
        }

        $dataTahunAjaran = TahunAjar::all();

        $tahunAjarId = $request->get('tahun_ajaran', $tahunAjarAktif ? $tahunAjarAktif->id : null); 

        $status = $request->get('status');

        $query = PenetapanPrakerin::with(['siswa.kelas', 'dudiJurusan.dudi', 'tahunAjar'])
            ->whereHas('siswa.kelas', function ($query) use ($jurusanId) {
                $query->where('jurusan_id', $jurusanId);
            });

        if ($tahunAjarId) {
            $query->where('tahun_ajar_id', $tahunAjarId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $dataPrakerin = $query->paginate(10);

        $query = PenetapanPrakerin::with(['siswa.kelas', 'dudiJurusan.dudi', 'tahunAjar'])
            ->whereHas('siswa.kelas', function ($query) use ($jurusanId) {
                $query->where('jurusan_id', $jurusanId);
            });

        if ($tahunAjarId) {
            $query->where('tahun_ajar_id', $tahunAjarId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $dataPrakerin = $query->get()->sort(function ($a, $b) {
            return strcmp(optional($a->siswa)->nama ?? '', optional($b->siswa)->nama ?? '')
                ?: strcmp(optional($a->dudiJurusan->dudi)->nama_dudi ?? '', optional($b->dudiJurusan->dudi)->nama_dudi ?? '')
                ?: strcmp(optional($b->tahunAjar)->periode_mulai ?? '', optional($a->tahunAjar)->periode_mulai ?? '')
                ?: strcmp($b->tanggal_mulai ?? '', $a->tanggal_mulai ?? '');
        });
        $dataPrakerin = new \Illuminate\Pagination\LengthAwarePaginator(
            $dataPrakerin, 
            $dataPrakerin->count(), 
            10, 
            $request->get('page', 1)
        );

        $siswa = Siswa::whereHas('kelas', function ($query) use ($jurusanId) {
            $query->where('jurusan_id', $jurusanId)
                ->whereHas('tahunAjar', function ($q) {
                    $q->where('status', 'Aktif');
                });
        })->orderBy('nama', 'asc')->get();

        $dudiJurusan = DudiJurusan::with('dudi')
            ->where('jurusan_id', $jurusanId)
            ->whereHas('tahunAjar', function ($query) {
                $query->where('status', 'Aktif');
            })
            ->get()
            ->sortBy(fn($item) => $item->dudi->nama_dudi ?? '');

        $tahunAjar = TahunAjar::all();

        return view('admin_jurusan.prakerin', compact('dataPrakerin', 'siswa', 'dudiJurusan', 'tahunAjar', 'dataTahunAjaran', 'tahunAjarAktif'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'dudi_jurusan_id' => 'required',
            'tahun_ajar_id' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ],[
            'siswa_id.required' => 'Siswa jurusan harus dipilih',
            'dudi_jurusan_id.required' => 'Penetapan DUDI harus dipilih',
            'tahun_ajar_id.required' => 'Tahun ajaran prakerin harus dipilih',
            'tanggal_mulai.required' => 'Tanggal mulai prakerin harus dipilih',
            'tanggal_selesai.required' => 'Tanggal selesai prakerin harus dipilih',
        ]);

        $siswaId = $request->siswa_id;
        $tanggalMulai = Carbon::parse($request->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($request->tanggal_selesai);
        $tahunAjar = TahunAjar::findOrFail($request->tahun_ajar_id);

        if (
            $tanggalMulai->lt(Carbon::parse($tahunAjar->periode_mulai)) ||
            $tanggalSelesai->gt(Carbon::parse($tahunAjar->periode_selesai))
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Tanggal mulai dan selesai harus berada di dalam rentang tahun ajar'
            ], 422);
        }

        $cekPenetapan = PenetapanPrakerin::where('siswa_id', $siswaId)
            ->whereIn('status', ['Berlangsung', 'Belum Dimulai'])
            ->exists();

        if ($cekPenetapan) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa ini sudah memiliki penetapan prakerin yang sedang berlangsung atau belum dimulai'
            ], 422);
        }

        $now = Carbon::now();

        if ($now->lt($tanggalMulai->startOfDay())) {
            $status = 'Belum Dimulai';
        } elseif ($now->between($tanggalMulai->startOfDay(), $tanggalSelesai->endOfDay())) {
            $status = 'Berlangsung';
        } else {
            $status = 'Selesai';
        }

        PenetapanPrakerin::create([
            'siswa_id' => $siswaId,
            'dudi_jurusan_id' => $request->dudi_jurusan_id,
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'tahun_ajar_id' => $request->tahun_ajar_id,
            'status' => $status,
        ]);

        return response()->json(['success' => true, 'message' => 'Penetapan prakerin berhasil ditambahkan']);
    }

    public function edit($id)
    {
        $penetapanPrakerin = PenetapanPrakerin::findOrFail($id);
        return response()->json($penetapanPrakerin);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required',
            'dudi_jurusan_id' => 'required',
            'tahun_ajar_id' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ],[
            'siswa_id.required' => 'Siswa jurusan harus dipilih',
            'dudi_jurusan_id.required' => 'Penetapan DUDI harus dipilih',
            'tahun_ajar_id.required' => 'Tahun ajaran prakerin harus dipilih',
            'tanggal_mulai.required' => 'Tanggal mulai prakerin harus dipilih',
            'tanggal_selesai.required' => 'Tanggal selesai prakerin harus dipilih',
        ]);

        $penetapan = PenetapanPrakerin::findOrFail($id);
        $siswaId = $request->siswa_id;
        $tanggalMulai = Carbon::parse($request->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($request->tanggal_selesai);
        $tahunAjar = TahunAjar::findOrFail($request->tahun_ajar_id);

        if (
            $tanggalMulai->lt(Carbon::parse($tahunAjar->periode_mulai)) ||
            $tanggalSelesai->gt(Carbon::parse($tahunAjar->periode_selesai))
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Tanggal mulai dan selesai harus berada di dalam rentang tahun ajar'
            ], 422);
        }

        $cekPenetapan = PenetapanPrakerin::where('siswa_id', $siswaId)
            ->where('id', '!=', $penetapan->id)
            ->whereIn('status', ['Berlangsung', 'Belum Dimulai'])
            ->get(); 

        if ($cekPenetapan->isNotEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa ini sudah memiliki penetapan prakerin lain yang sedang berlangsung atau belum dimulai'
            ], 422);
        }

        $now = Carbon::now();
        if ($now->lt($tanggalMulai)) {
            $status = 'Belum Dimulai';
        } elseif ($now->between($tanggalMulai, $tanggalSelesai)) {
            $status = 'Berlangsung';
        } else {
            $status = 'Selesai';
        }

        $penetapan->update([
            'siswa_id' => $siswaId,
            'dudi_jurusan_id' => $request->dudi_jurusan_id,
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'tahun_ajar_id' => $request->tahun_ajar_id,
            'status' => $status,
        ]);

        return response()->json(['success' => true, 'message' => 'Penetapan prakerin berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $penetapan = PenetapanPrakerin::find($id);

        if (!$penetapan) {
            return response()->json(['success' => false, 'message' => 'Penetapan prakerin tidak ditemukan'], 404);
        }

        if ($penetapan->status === 'Berlangsung') {
            return response()->json(['success' => false, 'message' => 'Penetapan prakerin yang sedang berlangsung tidak bisa dihapus'], 403);
        }

        $penetapan->delete();

        return response()->json(['success' => true, 'message' => 'Penetapan prakerin berhasil dihapus']);
    }
}
