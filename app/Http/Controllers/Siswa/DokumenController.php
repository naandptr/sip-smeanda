<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Dokumen;
use Illuminate\Support\Str;

class DokumenController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        $dokumen = Dokumen::where('siswa_id', $siswa->id)->get()->keyBy('jenis');

        return view('siswa.dokumen', compact('dokumen'));

    }

    public function upload(Request $request, $jenis)
    {
        $request->validate([
            'dokumen' => 'required|file|mimes:pdf|max:2048',
        ]);

        $siswa = Auth::user()->siswa;

        $existing = Dokumen::where('siswa_id', $siswa->id)->where('jenis', $jenis)->first();

        if ($existing && Storage::exists($existing->file)) {
            Storage::delete($existing->file);
        }

        if ($request->hasFile('dokumen')) {
            $folder = "dokumen/{$siswa->nis}";
            $filename = "{$siswa->nis}_" . Str::slug($jenis) . ".pdf";
            $stored = $request->file('dokumen')->storeAs($folder, $filename, 'public');

            if (!$stored) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan file.',
                ], 500);
            }

            $dokumen = Dokumen::updateOrCreate(
                ['siswa_id' => $siswa->id, 'jenis' => $jenis],
                ['file' => $stored]
            );
            $dokumen->touch(); 

            return response()->json([
                'success' => true,
                'message' => ucfirst($jenis) . ' berhasil diunggah!',
                'file_name' => basename($stored),
                'file_url' => Storage::url($stored)
            ]);            
        }

        return response()->json([
            'success' => false,
            'message' => 'File tidak ditemukan dalam permintaan.',
        ], 400);
    }

    public function download($id)
    {
        $dokumen = Dokumen::findOrFail($id);

        if ($dokumen->siswa_id !== Auth::user()->siswa->id) {
            abort(403);
        }

        $filePath = Storage::disk('public')->path($dokumen->file);

        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->download($filePath);
    }
}
