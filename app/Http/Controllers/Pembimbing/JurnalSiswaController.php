<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Jurnal;
use App\Models\Validasi;
use Illuminate\Support\Facades\Auth;

class JurnalSiswaController extends Controller
{
    public function index()
    {
        $pembimbingId = Auth::user()->pembimbing->id;

        $siswaBimbingan = Siswa::with(['penetapanPrakerinTerbaru.dudiJurusan', 'kelas'])->get()->filter(function ($siswa) use ($pembimbingId) {
            $penetapan = $siswa->penetapanPrakerinTerbaru;
            return $penetapan && 
                   $penetapan->dudiJurusan &&
                   $penetapan->dudiJurusan->pembimbing_id == $pembimbingId;
        })->map(function ($siswa) {
            $penetapan = $siswa->penetapanPrakerinTerbaru;

            $jurnalTerkirim = $penetapan->jurnal()->count();
            $jurnalValid = $penetapan->jurnal()
                ->whereHas('validasi', fn ($q) => $q->where('status_validasi', 'selesai'))
                ->count();

            return [
                'siswa' => $siswa,
                'penetapan_id' => $penetapan->id,
                'kelas' => $siswa->kelas->nama_kelas ?? '-',
                'jurnal_terkirim' => $jurnalTerkirim,
                'jurnal_validasi' => $jurnalValid,
            ];
        })->values();

        return view('guru.jurnal', compact('siswaBimbingan'));
    }

    public function detail($siswa_id)
    {
        $siswa = Siswa::with(['penetapanPrakerinTerbaru.dudiJurusan'])->findOrFail($siswa_id);

        $pembimbingId = Auth::user()->pembimbing->id;

        $isBimbingan = optional(optional($siswa->penetapanPrakerinTerbaru)->dudiJurusan)->pembimbing_id === $pembimbingId;

        if (!$isBimbingan) {
            abort(403, 'Akses ditolak');
        }

        $penetapan = $siswa->penetapanPrakerinTerbaru;

        $jurnalList = $penetapan
            ? $penetapan->jurnal()->with('validasi')->get()
            : collect();

        return view('guru.detail_jurnal', compact('siswa', 'jurnalList'));
    }

    public function validasi(Request $request, $id)
    { 

        $request->validate([
            'catatan' => 'required|string',
        ]);

        $existing = Validasi::where('jurnal_id', $id)
        ->where('status_validasi', 'Selesai')
        ->first();

        if ($existing) {
            return response()->json([
            'success' => false,
            'message' => 'Jurnal ini sudah divalidasi dan tidak bisa diubah lagi.'
            ], 403); 
        }

        $validasi = Validasi::firstOrNew([
            'jurnal_id' => $id, 
        ]);

        $validasi->catatan = $request->catatan;
        $validasi->status_validasi = 'Selesai';
        $validasi->save();

        return response()->json(['success' => true, 'message' => 'Jurnal berhasil divalidasi']);
    }
}
