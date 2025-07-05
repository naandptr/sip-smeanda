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
use App\Models\PenetapanPrakerin;

class DudiJurusanController extends Controller
{
    public function index(Request $request)
    {
        $jurusanId = Auth::user()->adminJurusan->jurusan_id;

        $tahunAjar = TahunAjar::all();

        $tahunAjarAktif = TahunAjar::where('status', 'aktif')->first();

        if (!$tahunAjarAktif) {
            return back()->with('error', 'Tidak ada tahun ajaran aktif yang ditemukan.');
        }

        $tahunAjarId = $request->get('tahun_ajaran', $tahunAjarAktif ? $tahunAjarAktif->id : null); 

        $dataDudiJurusan = DudiJurusan::with(['pembimbing', 'tahunAjar', 'dudi'])
            ->where('jurusan_id', $jurusanId)
            ->where('tahun_ajar_id', $tahunAjarId)
            ->paginate(10);

        $sorted = $dataDudiJurusan->items(); 
        usort($sorted, function ($a, $b) {
            return strcmp($a->pembimbing->nama ?? '', $b->pembimbing->nama ?? '')
                ?: strcmp($a->tahunAjar->tahun_ajaran ?? '', $b->tahunAjar->tahun_ajaran ?? '')
                ?: strcmp($a->dudi->nama_dudi ?? '', $b->dudi->nama_dudi ?? '');
        });


        $dataDudiJurusan = new \Illuminate\Pagination\LengthAwarePaginator(
            $sorted, 
            $dataDudiJurusan->total(), 
            $dataDudiJurusan->perPage(), 
            $dataDudiJurusan->currentPage(), 
            ['path' => \Request::url(), 'query' => \Request::query()] 
        );

        $dudi = Dudi::all();
        $pembimbing = Pembimbing::orderBy('nama', 'asc')->get();

        return view('admin_jurusan.dudi_jurusan', compact('dataDudiJurusan', 'dudi', 'tahunAjar', 'pembimbing', 'tahunAjarAktif'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dudi_id' => 'required',
            'pembimbing_id' => 'required',
            'tahun_ajar_id' => 'required',
        ],[
            'dudi_id.required' => 'Lokasi DUDI harus dipilih',
            'pembimbing_id.required' => 'Pembimbing DUDI harus dipilih',
            'tahun_ajar_id.required' => 'Tahun ajaran harus dipilih',
        ]);

        $jurusanId = Auth::user()->adminJurusan->jurusan_id;

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

        $doubleAssignment = DudiJurusan::where('pembimbing_id', $request->pembimbing_id)
            ->where('tahun_ajar_id', $request->tahun_ajar_id)
            ->where('dudi_id', $request->dudi_id)
            ->where('jurusan_id', $jurusanId) 
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
            'pembimbing_id' => 'required',
            'tahun_ajar_id' => 'required'
        ],[
            'dudi_id.required' => 'Lokasi DUDI harus dipilih',
            'pembimbing_id.required' => 'Pembimbing DUDI harus dipilih',
            'tahun_ajar_id.required' => 'Tahun ajaran harus dipilih',
        ]);

        $dudiJurusan = DudiJurusan::findOrFail($id);
        $jurusanId = Auth::user()->adminJurusan->jurusan_id;

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

    // public function destroy($id)
    // {
    //     DudiJurusan::destroy($id);
    //     return response()->json(['success' => true, 'message' => 'Penetapan DUDI berhasil dihapus']);
    // }

    public function destroy($id)
    {
        $dudiJurusan = DudiJurusan::findOrFail($id);

        // Cek relasi ke tabel lain
        if (
            PenetapanPrakerin::where('dudi_jurusan_id', $dudiJurusan->id)->exists() 
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Penetapan DUDI tidak bisa dihapus karena digunakan di data lain'
            ], 400);
        }

        $dudiJurusan->delete();

        return response()->json(['success' => true, 'message' => 'Penetapan DUDI berhasil dihapus']);
    }

    
}
