<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Models\PenetapanPrakerin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class PresensiController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        $penetapan = PenetapanPrakerin::where('siswa_id', $siswa->id)->first();

        if (!$penetapan) {
            $emptyPresensi = new LengthAwarePaginator([], 0, 10);
            return view('siswa.presensi', ['dataPresensi' => $emptyPresensi]);
        }

        $dataPresensi = Presensi::where('penetapan_prakerin_id', $penetapan->id)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('siswa.presensi', compact('dataPresensi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenisPresensi' => 'required|in:Presensi Datang,Presensi Pulang',
            'statusPresensi' => 'nullable|in:Hadir,Izin,Sakit',
            'filePresensi' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'jenisPresensi.required' => 'Jenis presensi harus dipilih',
            'filePresensi.required' => 'Bukti presensi harus diunggah',
            'filePresensi.mimes' => 'Format berkas harus JPG, JPEG, PNG, atau PDF',
            'filePresensi.max' => 'Ukuran berkas maksimal 2MB',
        ]);

        if ($request->jenisPresensi === 'Presensi Datang' && !$request->statusPresensi) {
            return response()->json(['message' => 'Status presensi harus dipilih untuk presensi datang'], 422);
        }

        $siswa = Auth::user()->siswa;
        $today = Carbon::parse($request->tglPresensiFormatted)->startOfDay();
        $jenis = $request->jenisPresensi;

        $penetapan = PenetapanPrakerin::where('siswa_id', $siswa->id)
            ->where('tanggal_mulai', '<=', $today)
            ->where('tanggal_selesai', '>=', $today)
            ->first();

        if (!$penetapan) {
            return response()->json(['message' => 'Anda tidak dalam periode prakerin'], 400);
        }

        $existingPresensi = Presensi::where('penetapan_prakerin_id', $penetapan->id)
            ->whereDate('tanggal', $today)
            ->get();

        if ($jenis === 'Presensi Datang' && $existingPresensi->where('jenis_presensi', 'Presensi Datang')->count() > 0) {
            return response()->json(['message' => 'Anda sudah mengisi presensi datang hari ini'], 400);
        }

        if ($jenis === 'Presensi Pulang') {
            $presensiDatang = $existingPresensi->where('jenis_presensi', 'Presensi Datang')->first();
            if (!$presensiDatang) {
                return response()->json(['message' => 'Anda harus presensi datang terlebih dahulu'], 400);
            }
            if ($existingPresensi->where('jenis_presensi', 'Presensi Pulang')->count() > 0) {
                return response()->json(['message' => 'Anda sudah mengisi presensi pulang hari ini'], 400);
            }
        }

        $ext = $request->file('filePresensi')->getClientOriginalExtension();
        $folder = "presensi/{$siswa->nis}";
        $filename = $siswa->nis . '_' . strtolower(str_replace(' ', '_', $jenis)) . '_' . $today->format('Ymd') . '.' . $ext;

        $stored = $request->file('filePresensi')->storeAs($folder, $filename, 'public');

        if (!$stored) {
            return response()->json(['message' => 'Gagal menyimpan file presensi'], 500);
        }

        $presensi = new Presensi([
            'penetapan_prakerin_id' => $penetapan->id,
            'tanggal' => $today,
            'jenis_presensi' => $jenis,
            'status_kehadiran' => $jenis === 'Presensi Datang' ? $request->statusPresensi : null,
            'keterangan' => $request->ketAbsen,
            'file' => $stored,
            'presensi_datang_id' => $jenis === 'Presensi Pulang' ? $presensiDatang->id ?? null : null
        ]);

        $presensi->save();

        return response()->json([
            'message' => 'Presensi berhasil dikirim',
            'file_url' => Storage::url($stored),
        ]);
    }

}