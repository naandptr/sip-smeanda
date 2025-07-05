<?php

namespace App\Http\Controllers\AdminUtama;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dudi;
use App\Models\DudiJurusan;

class DudiController extends Controller
{
    public function index()
    {
        $dataDudi = Dudi::orderBy('nama_dudi', 'asc')->paginate(10);
        return view('admin_utama.lokasi', compact('dataDudi'));
    }

    public function store(Request $request)
    {
        // Cek apakah nama DUDI sudah digunakan sebelumnya
        if (Dudi::where('nama_dudi', $request->nama_dudi)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Lokasi sudah ada sebelumnya'
            ], 400);
        }

        $request->validate([
            'nama_dudi' => 'required|string|max:255|unique:tbl_dudi,nama_dudi',
            'alamat' => 'required|string|max:255',
            'bidang_usaha' => 'required|string|max:255',
            'telp' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ],[
            'nama_dudi.required' => 'Nama DUDI harus diisi',
            'alamat.required' => 'Alamat DUDI harus diisi',
            'bidang_usaha.required' => 'Bidang usaha harus diisi',
            'telp.required' => 'Nomor telepon DUDI harus diisi',
            'email.required' => 'Email DUDI harus diisi',
            'email.email' => 'Format email tidak valid',
        ]);

        Dudi::create($request->all());

        return response()->json(['success' => true, 'message' => 'Lokasi berhasil ditambahkan']);
    }

    public function edit($id)
    {
        $dudi = Dudi::findOrFail($id);
        return response()->json($dudi);
    }

    public function update(Request $request, $id)
    {
        if (
            Dudi::where('nama_dudi', $request->nama_dudi)
                ->where('id', '!=', $id)
                ->exists()
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Lokasi sudah ada sebelumnya'
            ], 400);
        }

        $request->validate([
            'nama_dudi' => 'required|string|max:255|unique:tbl_dudi,nama_dudi,' . $id,
            'alamat' => 'required|string|max:255',
            'bidang_usaha' => 'required|string|max:255',
            'telp' => 'required|string|max:255',
            'email' => 'required|string|max:255'
        ],[
            'nama_dudi.required' => 'Nama DUDI harus diisi',
            'alamat.required' => 'Alamat DUDI harus diisi',
            'bidang_usaha.required' => 'Bidang usaha harus diisi',
            'telp.required' => 'Nomor telepon DUDI harus diisi',
            'email.required' => 'Email DUDI harus diisi',
        ]);

        $dudi = Dudi::findOrFail($id);

        $dudi->update($request->all());

        return response()->json(['success' => true, 'message' => 'Lokasi berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $dudi = Dudi::findOrFail($id);

        // Cek relasi ke tabel lain
        if (
            DudiJurusan::where('dudi_id', $dudi->id)->exists() 
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Lokasi tidak bisa dihapus karena digunakan di data lain'
            ], 400);
        }

        $dudi->delete();

        return response()->json(['success' => true, 'message' => 'Lokasi berhasil dihapus']);
    }
}
