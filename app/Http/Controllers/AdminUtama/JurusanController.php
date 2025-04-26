<?php

namespace App\Http\Controllers\AdminUtama;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Log; 

class JurusanController extends Controller
{
    public function index()
    {
        $status = request('status', 'aktif'); 

        $dataJurusan = Jurusan::where(function ($query) use ($status) {
            if ($status) {
                $query->where('status', $status);
            }
        })
        ->orderBy('nama_jurusan', 'asc')
        ->paginate(10);

        return view('admin_utama.jurusan', compact('dataJurusan'));
    }

    public function store(Request $request)
    {
        $existsKode = Jurusan::where('kode_jurusan', $request->kode_jurusan)->exists();
        $existsNama = Jurusan::where('nama_jurusan', $request->nama_jurusan)->exists();

        if ($existsKode) {
            return response()->json([
                'success' => false,
                'message' => 'Kode jurusan sudah digunakan'
            ], 400);
        }

        if ($existsNama) {
            return response()->json([
                'success' => false,
                'message' => 'Nama jurusan sudah digunakan'
            ], 400);
        }

        $request->validate([
            'nama_jurusan' => 'required|string|max:255|unique:tbl_jurusan,nama_jurusan',
            'kode_jurusan' => 'required|string|max:255|unique:tbl_jurusan,kode_jurusan',
            'status' => 'required|in:Aktif,Nonaktif'
        ],[
            'nama_jurusan.required' => 'Nama jurusan harus diisi',
            'kode_jurusan.required' => 'Kode jurusan harus diisi',
            'status.required' => 'Status jurusan harus dipilih',
        ]);

        Jurusan::create($request->all());

        return response()->json(['success' => true, 'message' => 'Jurusan berhasil ditambahkan']);
    }

    public function edit($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return response()->json($jurusan);
    }

    public function update(Request $request, $id)
    {
        $existsKode = Jurusan::where('kode_jurusan', $request->kode_jurusan)
        ->where('id', '!=', $id)
        ->exists();

        $existsNama = Jurusan::where('nama_jurusan', $request->nama_jurusan)
            ->where('id', '!=', $id)
            ->exists();

        if ($existsKode) {
            return response()->json([
                'success' => false,
                'message' => 'Kode jurusan sudah digunakan'
            ], 400);
        }

        if ($existsNama) {
            return response()->json([
                'success' => false,
                'message' => 'Nama jurusan sudah digunakan'
            ], 400);
        }
        
        $request->validate([
            'nama_jurusan' => 'required|string|max:255|unique:tbl_jurusan,nama_jurusan,' . $id,
            'kode_jurusan' => 'required|string|max:255|unique:tbl_jurusan,kode_jurusan,' . $id,
            'status' => 'required|in:Aktif,Nonaktif'
        ],[
            'nama_jurusan.required' => 'Nama jurusan harus diisi',
            'kode_jurusan.required' => 'Kode jurusan harus diisi',
            'status.required' => 'Status jurusan harus dipilih',
        ]);

        $jurusan = Jurusan::findOrFail($id);

        $jurusan->update($request->all());

        return response()->json(['success' => true, 'message' => 'Jurusan berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);

        if ($jurusan->status == 'Aktif') {
            return response()->json(['success' => false, 'message' => 'Tidak dapat menghapus jurusan yang aktif'], 400);
        }

        $jurusan->delete();
       
        return response()->json(['success' => true, 'message' => 'Jurusan berhasil dihapus']);
    }
}