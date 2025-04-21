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
    public function index()
    {
        $jurusanId = Auth::user()->adminJurusan->jurusan_id;

        // $dataPrakerin = PenetapanPrakerin::with(['siswa', 'dudiJurusan.dudi', 'tahunAjar'])
        // ->whereHas('siswa.kelas', function ($query) use ($jurusanId) {
        //     $query->where('jurusan_id', $jurusanId);
        // })
        //     ->get()
        //     ->sortBy(fn($a) => $a->siswa->nama ?? '')
        //     ->sortBy(fn($a) => $a->dudiJurusan->dudi->nama_dudi ?? '')
        //     ->sortByDesc(fn($a) => $a->tahunAjar->periode_mulai ?? '')
        //     ->sortByDesc(fn($a) => $a->tanggal_mulai);

        $dataPrakerin = PenetapanPrakerin::with(['siswa.kelas', 'dudiJurusan.dudi', 'tahunAjar'])
            ->whereHas('siswa.kelas', function ($query) use ($jurusanId) {
                $query->where('jurusan_id', $jurusanId);
            })
            ->paginate(10); 

        $sorted = $dataPrakerin->getCollection()->sort(function ($a, $b) {
            return strcmp($a->siswa->nama ?? '', $b->siswa->nama ?? '')
                ?: strcmp($a->dudiJurusan->dudi->nama_dudi ?? '', $b->dudiJurusan->dudi->nama_dudi ?? '')
                ?: strcmp($b->tahunAjar->periode_mulai ?? '', $a->tahunAjar->periode_mulai ?? '')
                ?: strcmp($b->tanggal_mulai ?? '', $a->tanggal_mulai ?? '');
        });

        $dataPrakerin->setCollection($sorted);

        $siswa = Siswa::whereHas('kelas', function ($query) use ($jurusanId) {
            $query->where('jurusan_id', $jurusanId);
        })->orderBy('nama', 'asc')->get();

        $dudiJurusan = DudiJurusan::with('dudi')
            ->where('jurusan_id', $jurusanId)
            ->get()
            ->sortBy(fn($item) => $item->dudi->nama_dudi ?? '');

        $tahunAjar = TahunAjar::where('status', 'aktif')->get();

        return view('admin_jurusan.prakerin', compact('dataPrakerin', 'siswa', 'dudiJurusan', 'tahunAjar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'dudi_jurusan_id' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'tahun_ajar_id' => 'required',
        ]);

        $siswaId = $request->siswa_id;
        $tanggalMulai = Carbon::parse($request->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($request->tanggal_selesai);
        $tahunAjar = TahunAjar::findOrFail($request->tahun_ajar_id);

        // Validasi apakah tanggal berada dalam rentang tahun ajar
        if (
            $tanggalMulai->lt(Carbon::parse($tahunAjar->periode_mulai)) ||
            $tanggalSelesai->gt(Carbon::parse($tahunAjar->periode_selesai))
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Tanggal mulai dan selesai harus berada di dalam rentang tahun ajar.'
            ], 422);
        }

        // Cek jika siswa sudah punya penetapan dengan status aktif
        $cekPenetapan = PenetapanPrakerin::where('siswa_id', $siswaId)
            ->whereIn('status', ['Berlangsung', 'Belum Dimulai'])
            ->exists();

        if ($cekPenetapan) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa ini sudah memiliki penetapan prakerin yang sedang berlangsung atau belum dimulai.'
            ], 422);
        }

        // Tentukan status berdasarkan tanggal hari ini
        $now = Carbon::now();
        if ($now->lt($tanggalMulai)) {
            $status = 'Belum Dimulai';
        } elseif ($now->between($tanggalMulai, $tanggalSelesai)) {
            $status = 'Berlangsung';
        } else {
            $status = 'Selesai';
        }

        // Simpan data
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
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'tahun_ajar_id' => 'required',
        ]);

        $penetapan = PenetapanPrakerin::findOrFail($id);
        $siswaId = $request->siswa_id;
        $tanggalMulai = Carbon::parse($request->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($request->tanggal_selesai);
        $tahunAjar = TahunAjar::findOrFail($request->tahun_ajar_id);

        // Validasi tanggal dalam tahun ajar
        if (
            $tanggalMulai->lt(Carbon::parse($tahunAjar->periode_mulai)) ||
            $tanggalSelesai->gt(Carbon::parse($tahunAjar->periode_selesai))
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Tanggal mulai dan selesai harus berada di dalam rentang tahun ajar.'
            ], 422);
        }

        // Cek jika siswa punya penetapan lain yang aktif (bukan dirinya sendiri)
        $cekPenetapan = PenetapanPrakerin::where('siswa_id', $siswaId)
            ->where('id', '!=', $penetapan->id)
            ->whereIn('status', ['Berlangsung', 'Belum Dimulai'])
            ->get(); // ✅ tambahin ini

        if ($cekPenetapan->isNotEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa ini sudah memiliki penetapan prakerin lain yang sedang berlangsung atau belum dimulai.'
            ], 422);
        }

        // Tentukan status berdasarkan waktu sekarang
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
