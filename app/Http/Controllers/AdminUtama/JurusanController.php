<?php

namespace App\Http\Controllers\AdminUtama;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Log; 

class JurusanController extends Controller
{
    // Method untuk menampilkan halaman kelola jurusan
    public function index()
    {
        $jurusan = Jurusan::orderBy('nama_jurusan', 'asc')->get();
        return view('admin_utama.jurusan', compact('jurusan'));
    }

    // Method untuk menyimpan data baru
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

    // Method untuk menampilkan form edit (digunakan untuk AJAX)
    public function edit($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return response()->json($jurusan);
    }

    // Method untuk update data
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

    // Method untuk menghapus data
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