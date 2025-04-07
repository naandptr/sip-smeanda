<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\PenetapanPrakerin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class AbsenController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        $penetapan = PenetapanPrakerin::where('siswa_id', $siswa->id)->first();

        $dataAbsen = Absen::where('penetapan_prakerin_id', $penetapan->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('siswa.absen', compact('dataAbsen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenisAbsen' => 'required|in:Absen Datang,Absen Pulang',
            'statusAbsen' => 'nullable|in:Hadir,Izin,Sakit',
            'fileAbsen' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $siswa = Auth::user()->siswa;
        $today = Carbon::parse($request->tglAbsenFormatted);
        $jenis = $request->jenisAbsen;

        $penetapan = PenetapanPrakerin::where('siswa_id', $siswa->id)
            ->where('tanggal_mulai', '<=', $today)
            ->where('tanggal_selesai', '>=', $today)
            ->first();

        if (!$penetapan) {
            return response()->json(['message' => 'Anda tidak dalam periode prakerin.'], 400);
        }

        $existingAbsen = Absen::where('penetapan_prakerin_id', $penetapan->id)
            ->whereDate('tanggal', $today)
            ->get();

        // Cek absen datang
        if ($jenis === 'Absen Datang' && $existingAbsen->where('jenis_absen', 'Absen Datang')->count() > 0) {
            return response()->json(['message' => 'Anda sudah mengisi absen datang hari ini.'], 400);
        }

        // Cek absen pulang
        if ($jenis === 'Absen Pulang') {
            $absenDatang = $existingAbsen->where('jenis_absen', 'Absen Datang')->first();
            if (!$absenDatang) {
                return response()->json(['message' => 'Anda harus absen datang terlebih dahulu.'], 400);
            }
            if ($existingAbsen->where('jenis_absen', 'Absen Pulang')->count() > 0) {
                return response()->json(['message' => 'Anda sudah mengisi absen pulang hari ini.'], 400);
            }
        }

     
        $ext = $request->file('fileAbsen')->getClientOriginalExtension();
        $folderNisn = 'absen/' . $siswa->nisn;
        $namaFile = $siswa->nisn . '_' . strtolower(str_replace(' ', '_', $jenis)) . '_' . $today->format('Ymd') . '.' . $ext;

        $filePath = $request->file('fileAbsen')->storeAs('public/' . $folderNisn, $namaFile);


        $absen = new Absen([
            'penetapan_prakerin_id' => $penetapan->id,
            'tanggal' => $today,
            'jenis_absen' => $jenis,
            'status_kehadiran' => $jenis === 'Absen Datang' ? $request->statusAbsen : null,
            'keterangan' => $request->ketAbsen,
            'file' => str_replace('public/', '', $filePath), 
            'absen_datang_id' => $jenis === 'Absen Pulang' ? $absenDatang->id ?? null : null
        ]);

        $absen->save();

        return response()->json(['message' => 'Absen berhasil dikirim.']);
    }

}
