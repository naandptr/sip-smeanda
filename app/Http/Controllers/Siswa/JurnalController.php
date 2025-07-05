<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\Validasi;
use App\Models\PenetapanPrakerin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class JurnalController extends Controller
{
    public function index()
    {
        $siswaId = Auth::user()->siswa->id;

        $penetapan = PenetapanPrakerin::where('siswa_id', $siswaId)->first();

        if (!$penetapan) {
            $emptyJurnal = new LengthAwarePaginator([], 0, 10);
            return view('siswa.jurnal', ['dataJurnal' => $emptyJurnal]);
        }

        $dataJurnal = Jurnal::with('validasi')
            ->where('penetapan_prakerin_id', $penetapan->id)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('siswa.jurnal', compact('dataJurnal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|min:150',
        ],[
            'content.required' => 'Deskripsi kegiatan harus diisi',
            'content.min' => 'Deskripsi kegiatan minimal 150 karakter',
        ]);

        $siswaId = Auth::user()->siswa->id;
        $penetapan = PenetapanPrakerin::where('siswa_id', $siswaId)->first();

        if (!$penetapan) {
            return response()->json(['message' => 'Anda tidak dalam periode prakerin.'], 404);
        }

        $tanggalHariIni = Carbon::now('Asia/Jakarta')->format('Y-m-d');

        $cekJurnal = Jurnal::where('penetapan_prakerin_id', $penetapan->id)
            ->whereDate('tanggal', $tanggalHariIni)
            ->first();

        if ($cekJurnal) {
            return response()->json(['message' => 'Jurnal untuk hari ini sudah dibuat.'], 409);
        }

        $jurnal = Jurnal::create([
            'penetapan_prakerin_id' => $penetapan->id,
            'tanggal' => $tanggalHariIni,
            'deskripsi' => $request->input('content'),
        ]);

        Validasi::create([
            'jurnal_id' => $jurnal->id,
            'status_validasi' => 'Menunggu',
            'catatan' => null,
        ]);

        return response()->json(['message' => 'Jurnal berhasil ditambahkan']);
    }

    public function destroy($id)
    {
        $jurnal = Jurnal::findOrFail($id);

        if ($jurnal->penetapanPrakerin->siswa_id !== Auth::user()->siswa->id) {
            return response()->json(['message' => 'Tidak diizinkan'], 403);
        }

        $validasi = $jurnal->validasi;

        if ($validasi && $validasi->status_validasi === 'Selesai') {
            return response()->json(['message' => 'Jurnal sudah divalidasi dan tidak dapat dihapus'], 400);
        }

        $jurnal->validasi()->delete();

        $jurnal->delete();

        return response()->json(['message' => 'Jurnal berhasil dihapus']);
    }
}
