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
        $dataJurusan = Jurusan::orderBy('nama_jurusan', 'asc')->paginate(10);
        return view('admin_utama.jurusan', compact('dataJurusan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'kode_jurusan' => 'required|string|max:255',
            'status' => 'required|in:Aktif,Nonaktif'
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
        $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'kode_jurusan' => 'required|string|max:255',
            'status' => 'required|in:Aktif,Nonaktif'
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