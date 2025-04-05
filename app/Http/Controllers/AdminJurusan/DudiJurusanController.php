<?php

namespace App\Http\Controllers\AdminJurusan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DudiJurusan;
use App\Models\Dudi;
use App\Models\Jurusan;
use App\Models\TahunAjar;
use App\Models\Pembimbing;

class DudiJurusanController extends Controller
{
    public function index()
    {
        $dudiJurusan = DudiJurusan::orderBy('dudi_id', 'asc')->get();
        $dudi = Dudi::all();
        $jurusan = Jurusan::where('status', 'aktif')->get();
        $tahunAjar = TahunAjar::where('status', 'aktif')->orderBy('periode_mulai', 'desc')->get();
        $pembimbing = Dudi::all();
        return view('admin_jurusan.dudi_jurusan', compact('dudiJurusan', 'dudi', 'jurusan', 'tahunAjar', 'pembimbing'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dudi_id' => 'required',
            'jurusan_id' => 'required',
            'tahun_ajar_id' => 'required',
            'pembimbing_id' => 'required'
        ]);

        DudiJurusan::create([
            'dudi_id' => $request->dudi_id,
            'jurusan_id' => $request->jurusan_id,
            'tahun_ajar_id' => $request->tahun_ajar_id,
            'pembimbing_id' => $request->pembimbing_id
        ]);

        return response()->json(['success' => true, 'message' => 'Penetapan DUDI berhasil ditambahkan']);
    }

    public function edit($id)
    {
        $dudiJurusan = DudiJurusan::findOrFail($id);
        return response()->json($dudiJurusan);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'dudi_id' => 'required',
            'jurusan_id' => 'required',
            'tahun_ajar_id' => 'required',
            'pembimbing_id' => 'required'
        ]);

        $dudiJurusan = DudiJurusan::findOrFail($id);
        $dudiJurusan->update($request->all());

        return response()->json(['success' => true, 'message' => 'Penetapan DUDI berhasil diperbarui']);
    }

    public function destroy($id)
    {
        DudiJurusan::destroy($id);
        return response()->json(['success' => true, 'message' => 'Penetapan DUDI berhasil dihapus']);
    }
}
