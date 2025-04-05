<?php

namespace App\Http\Controllers\AdminUtama;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\TahunAjar;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with(['jurusan', 'tahunAjar'])->get();
        $jurusan = Jurusan::where('status', 'aktif')->get();
        $tahunAjar = TahunAjar::where('status', 'aktif')->orderBy('periode_mulai', 'desc')->get();
    
        return view('admin_utama.kelas', compact('kelas', 'jurusan', 'tahunAjar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'jurusan_id' => 'required',
            'tahun_ajar_id' => 'required',
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'jurusan_id' => $request->jurusan_id,
            'tahun_ajar_id' => $request->tahun_ajar_id,
        ]);

        return response()->json(['success' => true, 'message' => 'Kelas berhasil ditambahkan']);
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        return response()->json($kelas);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'jurusan_id' => 'required',
            'tahun_ajar_id' => 'required',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->all());

        return response()->json(['success' => true, 'message' => 'Kelas berhasil diperbarui']);
    }

    public function destroy($id)
    {
        Kelas::destroy($id);
        return response()->json(['success' => true, 'message' => 'Kelas berhasil dihapus']);
    }
}
