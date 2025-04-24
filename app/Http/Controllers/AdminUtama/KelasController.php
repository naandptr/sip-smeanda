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
        $dataKelas = Kelas::with(['jurusan', 'tahunAjar'])->paginate(10);
        $jurusan = Jurusan::where('status', 'aktif')->get();
        $tahunAjar = TahunAjar::where('status', 'aktif')->orderBy('periode_mulai', 'desc')->get();
    
        return view('admin_utama.kelas', compact('dataKelas', 'jurusan', 'tahunAjar'));
    }

    public function store(Request $request)
    {
        $cekKelas = Kelas::where('nama_kelas', $request->nama_kelas)
                    ->where('tahun_ajar_id', $request->tahun_ajar_id)
                    ->first();

        if ($cekKelas) {
            return response()->json([
                'success' => false,
                'message' => 'Nama kelas sudah digunakan pada tahun ajaran yang sama.'
            ], 422);
        }

        $request->validate([
            'nama_kelas' => 'required|string|max:255|',
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
        $cekKelas = Kelas::where('id', '!=', $id)
                    ->where('nama_kelas', $request->nama_kelas)
                    ->where('tahun_ajar_id', $request->tahun_ajar_id)
                    ->first();

        if ($cekKelas) {
            return response()->json([
                'success' => false,
                'message' => 'Nama kelas sudah digunakan pada tahun ajaran yang sama.'
            ], 422);
        }
        
        $request->validate([
            'nama_kelas' => 'required|string|max:255|',
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
