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

    public function edit($id)
    {
        $dudi = Dudi::findOrFail($id);
        return response()->json($dudi);
    }

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

    public function destroy($id)
    {
        $dudi = Dudi::findOrFail($id);
        $dudi->delete();

        return response()->json(['success' => true, 'message' => 'Lokasi berhasil dihapus']);
    }
}
