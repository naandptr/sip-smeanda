<?php

namespace App\Http\Controllers\AdminUtama;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dudi;

class DudiController extends Controller
{
    // Method untuk menampilkan halaman kelola dudi
    public function index()
    {
        $dudi = Dudi::orderBy('nama_dudi', 'asc')->get();
        return view('admin_utama.lokasi', compact('dudi'));
    }

    // Method untuk menyimpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_dudi' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'bidang_usaha' => 'required|string|max:255',
            'telp' => 'required|string|max:255',
            'email' => 'required|string|max:255',
        ]);

        Dudi::create($request->all());

        return response()->json(['success' => true, 'message' => 'Lokasi berhasil ditambahkan']);
    }

    // Method untuk menampilkan form edit (digunakan untuk AJAX)
    public function edit($id)
    {
        $dudi = Dudi::findOrFail($id);
        return response()->json($dudi);
    }

    // Method untuk update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_dudi' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'bidang_usaha' => 'required|string|max:255',
            'telp' => 'required|string|max:255',
            'email' => 'required|string|max:255'
        ]);

        $dudi = Dudi::findOrFail($id);

        $dudi->update($request->all());

        return response()->json(['success' => true, 'message' => 'Lokasi berhasil diperbarui']);
    }

    // Method untuk menghapus data
    public function destroy($id)
    {
        $dudi = Dudi::findOrFail($id);
        $dudi->delete();

        return response()->json(['success' => true, 'message' => 'Lokasi berhasil dihapus']);
    }
}
