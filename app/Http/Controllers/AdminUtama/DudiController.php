<?php

namespace App\Http\Controllers\AdminUtama;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dudi;

class DudiController extends Controller
{
    public function index()
    {
        $dataDudi = Dudi::orderBy('nama_dudi', 'asc')->paginate(10);
        return view('admin_utama.lokasi', compact('dataDudi'));
    }

    public function store(Request $request)
    {
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
            'email' => 'required|string|max:255',
        ],[
            'nama_dudi.required' => 'Nama DUDI harus diisi',
            'alamat.required' => 'Alamat DUDI harus diisi',
            'bidang_usaha.required' => 'Bidang usaha harus diisi',
            'telp.required' => 'Nomor telepon DUDI harus diisi',
            'email.required' => 'Email DUDI harus diisi',
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
        $dudi->delete();

        return response()->json(['success' => true, 'message' => 'Lokasi berhasil dihapus']);
    }
}
