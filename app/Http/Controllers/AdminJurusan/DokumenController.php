<?php

namespace App\Http\Controllers\AdminJurusan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Dokumen;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function index()
    {
        $jurusanId = Auth::user()->adminJurusan->jurusan_id;

        $daftarSiswa = Siswa::with(['dokumen', 'kelas.jurusan'])
            ->whereHas('kelas', function ($q) use ($jurusanId) {
                $q->where('jurusan_id', $jurusanId);
            })
            ->get();

        return view('admin_jurusan.dokumen', compact('daftarSiswa'));
    }

    public function download($id)
    {
        $dokumen = Dokumen::with('siswa.kelas')->findOrFail($id);

        $jurusanId = Auth::user()->adminJurusan->jurusan_id;

        if (!$dokumen->siswa || !$dokumen->siswa->kelas || $dokumen->siswa->kelas->jurusan_id !== $jurusanId) {
            abort(403, 'Unauthorized');
        }

        $filePath = Storage::disk('public')->path($dokumen->file);

        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->download($filePath);
    }
}
