<?php

namespace App\Http\Controllers\AdminJurusan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $tahunAjar = TahunAjar::where('status', 'aktif')->get();
        $pembimbing = Pembimbing::all();
        return view('admin_jurusan.dudi_jurusan', compact('dudiJurusan', 'dudi', 'jurusan', 'tahunAjar', 'pembimbing'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dudi_id' => 'required',
            'tahun_ajar_id' => 'required',
            'pembimbing_id' => 'required'
        ]);

        $jurusanId = Auth::user()->adminJurusan->jurusan_id;

        // Cek apakah DUDI ini sudah punya pembimbing di tahun ajaran dan jurusan yang sama
        $exists = DudiJurusan::where('dudi_id', $request->dudi_id)
        ->where('jurusan_id', $jurusanId)
        ->where('tahun_ajar_id', $request->tahun_ajar_id)
        ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'DUDI ini sudah memiliki pembimbing di tahun ajaran dan jurusan yang sama.'
            ], 422);
        }

        // Cek apakah pembimbing sudah ditugaskan ke DUDI yang sama pada tahun ajaran yang sama
        $doubleAssignment = DudiJurusan::where('pembimbing_id', $request->pembimbing_id)
            ->where('tahun_ajar_id', $request->tahun_ajar_id)
            ->where('dudi_id', $request->dudi_id)
            ->exists();

        if ($doubleAssignment) {
            return response()->json([
                'success' => false,
                'message' => 'Pembimbing ini sudah membimbing DUDI yang sama di tahun ajaran tersebut.'
            ], 422);
        }

        DudiJurusan::create([
            'dudi_id' => $request->dudi_id,
            'jurusan_id' => $jurusanId,
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
            'tahun_ajar_id' => 'required',
            'pembimbing_id' => 'required'
        ]);

        $dudiJurusan = DudiJurusan::findOrFail($id);
        $jurusanId = Auth::user()->adminJurusan->jurusan_id;

        // Cek jika ada data lain (selain yang sedang diupdate) dengan kombinasi yang sama
        $exists = DudiJurusan::where('id', '!=', $id)
        ->where('dudi_id', $request->dudi_id)
        ->where('jurusan_id', $jurusanId)
        ->where('tahun_ajar_id', $request->tahun_ajar_id)
        ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'DUDI ini sudah memiliki pembimbing di tahun ajaran dan jurusan yang sama.'
            ], 422);
        }

        $doubleAssignment = DudiJurusan::where('id', '!=', $id)
            ->where('pembimbing_id', $request->pembimbing_id)
            ->where('tahun_ajar_id', $request->tahun_ajar_id)
            ->where('dudi_id', $request->dudi_id)
            ->exists();

        if ($doubleAssignment) {
            return response()->json([
                'success' => false,
                'message' => 'Pembimbing ini sudah membimbing DUDI yang sama di tahun ajaran tersebut.'
            ], 422);
        }

        $dudiJurusan = DudiJurusan::findOrFail($id);

        $dudiJurusan->update([
            'dudi_id' => $request->dudi_id,
            'jurusan_id' => $jurusanId,
            'tahun_ajar_id' => $request->tahun_ajar_id,
            'pembimbing_id' => $request->pembimbing_id
        ]);

        return response()->json(['success' => true, 'message' => 'Penetapan DUDI berhasil diperbarui']);
    }

    public function destroy($id)
    {
        DudiJurusan::destroy($id);
        return response()->json(['success' => true, 'message' => 'Penetapan DUDI berhasil dihapus']);
    }
}
