<?php

namespace App\Http\Controllers\AdminUtama;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TahunAjar;
use App\Models\Kelas;
use App\Models\DudiJurusan;
use App\Models\PenetapanPrakerin;
use Illuminate\Support\Facades\Log; 

class TahunAjarController extends Controller
{
    public function index()
    {
        $dataTahunAjar = TahunAjar::orderBy('periode_mulai', 'desc')->paginate(10);
        return view('admin_utama.tahun_ajar', compact('dataTahunAjar'));
    }

    public function store(Request $request)
    {
        if (TahunAjar::where('tahun_ajaran', $request->tahun_ajaran)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Tahun ajaran sudah ada sebelumnya'
            ], 400);
        }

        $request->validate([
            'tahun_ajaran' => 'required|string|max:255|unique:tbl_tahun_ajar,tahun_ajaran',
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'required|date|after:periode_mulai',
            'status' => 'required|in:Aktif,Nonaktif'
        ],[
            'tahun_ajaran.required' => 'Tahun ajaran harus diisi',
            'periode_mulai.required' => 'Periode mulai harus diisi',
            'periode_selesai.required' => 'Periode selesai harus diisi',
            'status.required' => 'Status tahun ajaran harus dipilih',
        ]);

        if ($request->status == 'Aktif') {
            TahunAjar::query()->update(['status' => 'Nonaktif']);
        }

        TahunAjar::create($request->all());

        return response()->json(['success' => true, 'message' => 'Tahun ajaran berhasil ditambahkan']);
    }

    public function edit($id)
    {
        $tahunAjar = TahunAjar::findOrFail($id);
        return response()->json($tahunAjar);
    }

    public function update(Request $request, $id)
    {
        if (
            TahunAjar::where('tahun_ajaran', $request->tahun_ajaran)
                ->where('id', '!=', $id)
                ->exists()
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Tahun ajaran sudah ada sebelumnya'
            ], 400);
        }

        $request->validate([
            'tahun_ajaran' => 'required|string|max:255|unique:tbl_tahun_ajar,tahun_ajaran,' . $id,
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'required|date|after:periode_mulai',
            'status' => 'required|in:Aktif,Nonaktif'
        ],[
            'tahun_ajaran.required' => 'Tahun ajaran harus diisi',
            'periode_mulai.required' => 'Periode mulai harus diisi',
            'periode_selesai.required' => 'Periode selesai harus diisi',
            'status.required' => 'Status tahun ajaran harus dipilih',
        ]);

        $tahunAjar = TahunAjar::findOrFail($id);

        if ($request->status == 'Aktif') {
            TahunAjar::where('id', '!=', $id)->update(['status' => 'Nonaktif']);
        }

        $tahunAjar->update($request->all());

        return response()->json(['success' => true, 'message' => 'Tahun ajaran berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $tahunAjar = TahunAjar::findOrFail($id);

        if ($tahunAjar->status == 'Aktif') {
            return response()->json(['success' => false, 'message' => 'Tidak dapat menghapus tahun ajaran yang aktif'], 400);
        }

        // Cek relasi ke tabel lain
        if (
            Kelas::where('tahun_ajar_id', $tahunAjar->id)->exists() ||
            PenetapanPrakerin::where('tahun_ajar_id', $tahunAjar->id)->exists() ||
            DudiJurusan::where('tahun_ajar_id', $tahunAjar->id)->exists()
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Tahun ajaran tidak bisa dihapus karena digunakan di data lain'
            ], 400);
        }

        $tahunAjar->delete();

        return response()->json(['success' => true, 'message' => 'Tahun ajaran berhasil dihapus']);
    }

    public function toggleStatus($id)
    {
        $tahunAjar = TahunAjar::findOrFail($id);

        if ($tahunAjar->status === 'Nonaktif') {
            TahunAjar::where('id', '!=', $id)->update(['status' => 'Nonaktif']);
            $tahunAjar->status = 'Aktif';
        } else {
            $tahunAjar->status = 'Nonaktif';
        }

        $tahunAjar->save();

        return response()->json([
            'success' => true,
            'message' => 'Status tahun ajaran berhasil diubah',
            'status' => $tahunAjar->status
        ]);
    }

}