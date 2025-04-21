<?php

namespace App\Http\Controllers\AdminUtama;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TahunAjar;
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
        Log::info('Store method called with data: ', $request->all());

        $request->validate([
            'tahun_ajaran' => 'required|string|max:255',
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'required|date|after:periode_mulai',
            'status' => 'required|in:Aktif,Nonaktif'
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
        $request->validate([
            'tahun_ajaran' => 'required|string|max:255',
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'required|date|after:periode_mulai',
            'status' => 'required|in:Aktif,Nonaktif'
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