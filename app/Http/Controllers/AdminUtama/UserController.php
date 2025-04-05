<?php

namespace App\Http\Controllers\AdminUtama;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Pembimbing;
use App\Models\AdminJurusan;
use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
{
    // Ambil semua user dengan relasi yang sesuai
    $users = User::with([
        'siswa.kelas',         // Menyertakan data kelas di dalam siswa
        'pembimbing', 
        'adminJurusan.jurusan' // Menyertakan data jurusan di dalam admin jurusan
    ])
    ->whereNotIn('role', ['Admin Utama']) // Mengecualikan Admin Utama
        ->orderBy('created_at', 'desc')
        ->get();

    // Format data untuk ditampilkan di view
    $formattedUsers = $users->map(function ($user) {
        $userData = [
            'id' => $user->id,
            'username' => $user->username,
            'role' => $user->role,
            'email' => $user->email,
            'status' => $user->status
        ];

        // Tambahkan data detail berdasarkan role
        switch ($user->role) {
            case 'Siswa':
                if ($user->siswa) {
                    $userData['detail'] = [
                        'nama' => $user->siswa->nama,
                        'nisn' => $user->siswa->nisn,
                        'nama_kelas' => $user->siswa->kelas->nama_kelas ?? '-'
                    ];
                }
                break;

            case 'Guru':
                if ($user->pembimbing) {
                    $userData['detail'] = [
                        'nama' => $user->pembimbing->nama,
                        'nip' => $user->pembimbing->nip,
                        'telp' => $user->pembimbing->telp
                    ];
                }
                break;

            case 'Admin Jurusan':
                if ($user->adminJurusan) {
                    $userData['detail'] = [
                        'nama' => $user->adminJurusan->nama,
                        'nama_jurusan' => $user->adminJurusan->jurusan->nama_jurusan ?? '-'
                    ];
                }
                break;
        }

        return $userData;
    });

    return view('admin_utama.user', [
        'users' => $formattedUsers,
        'jurusans' => Jurusan::all(), // Untuk dropdown form
        'kelas' => Kelas::all() // Untuk dropdown form
    ]);
}

public function store(Request $request)
{
    // Mulai database transaction
    DB::beginTransaction();

    try {
        $request->validate([
            'roleUser' => 'required|in:Siswa,Guru,Admin Jurusan',
            'namaUser' => 'required|unique:tbl_users,username',
        ]);

        $user = User::create([
            'username' => $request->namaUser,
            'password' => bcrypt('123456'),
            'role' => $request->roleUser,
            'status' => User::STATUS_PENDING,
        ]);

        // Simpan data tambahan berdasarkan role
        if ($request->roleUser == 'Siswa') {
            $request->validate([
                'namaSiswa' => 'required',
                'nisnSiswa' => 'required|unique:tbl_siswa,nisn',
                'kelasSiswa' => 'required|exists:tbl_kelas,id',
            ]);

            $siswa = Siswa::create([
                'user_id' => $user->id,
                'nama' => $request->namaSiswa,
                'nisn' => $request->nisnSiswa,
                'kelas_id' => $request->kelasSiswa,
            ]);

            if (!$siswa) {
                throw new \Exception('Gagal menyimpan data siswa');
            }
        } 
        elseif ($request->roleUser == 'Guru') {
            $request->validate([
                'namaGuru' => 'required',
                'nipGuru' => 'required|unique:tbl_pembimbing,nip',
                'telpGuru' => 'required',
            ]);

            $pembimbing = Pembimbing::create([
                'user_id' => $user->id,
                'nama' => $request->namaGuru,
                'nip' => $request->nipGuru,
                'telp' => $request->telpGuru,
            ]);

            if (!$pembimbing) {
                throw new \Exception('Gagal menyimpan data pembimbing');
            }
        } 
        elseif ($request->roleUser == 'Admin Jurusan') {
            $request->validate([
                'namaAdm' => 'required',
                'jurusanAdm' => 'required|exists:tbl_jurusan,id',
            ]);

            $adminJurusan = AdminJurusan::create([
                'user_id' => $user->id,
                'nama' => $request->namaAdm,
                'jurusan_id' => $request->jurusanAdm,
            ]);

            if (!$adminJurusan) {
                throw new \Exception('Gagal menyimpan data admin jurusan');
            }
        }

        // Commit transaction jika semua berhasil
        DB::commit();

        return redirect()->back()->with('success', 'User berhasil ditambahkan!');

    } catch (\Illuminate\Validation\ValidationException $e) {
        DB::rollBack();
        
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        }
        
        return redirect()->back()
            ->withErrors($e->errors())
            ->withInput();
            
    } catch (\Exception $e) {
        DB::rollBack();
        
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem',
                'error' => $e->getMessage()
            ], 500);
        }
        
        return redirect()->back()
            ->with('error', 'Gagal menyimpan data: ' . $e->getMessage())
            ->withInput();
    }

    }

    public function edit($id)
    {
        $user = User::with(['siswa', 'pembimbing', 'adminJurusan'])->findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'namaUser' => 'required|unique:tbl_users,username,' . $id,
        ]);

        $user->update([
            'username' => $request->namaUser,
        ]);

        if ($request->roleUser == 'Siswa') {
            $request->validate([
                'namaSiswa' => 'required',
                'nisnSiswa' => 'required|unique:tbl_siswa,nisn,' . $user->siswa->id,
                'kelasSiswa' => 'required',
            ]);

            $user->siswa->update([
                'nama' => $request->namaSiswa,
                'nis' => $request->nisUser,
                'kelas_id' => $request->kelasSiswa,
            ]);
        } elseif ($request->roleUser == 'Guru') {
            $request->validate([
                'namaGuru' => 'required',
                'nipGuru' => 'required|unique:tbl_pembimbing,nip,' . $user->pembimbing->id,
                'telpGuru' => 'required',
            ]);

            $user->pembimbing->update([
                'nama' => $request->namaGuru,
                'nip' => $request->nipGuru,
                'telp' => $request->telpGuru,
            ]);
        } elseif ($request->roleUser == 'Admin Jurusan') {
            $request->validate([
                'namaAdm' => 'required',
                'jurusanAdm' => 'required',
            ]);

            $user->adminJurusan->update([
                'nama' => $request->namaAdm,
                'jurusan_id' => $request->jurusanAdm,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'User berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Hapus data tambahan berdasarkan role
        if ($user->role == 'Siswa' && $user->siswa) {
            $user->siswa->delete();
        } elseif ($user->role == 'Guru' && $user->pembimbing) {
            $user->pembimbing->delete();
        } elseif ($user->role == 'Admin Jurusan' && $user->adminJurusan) {
            $user->adminJurusan->delete();
        }

        $user->delete();

        return response()->json(['success' => true, 'message' => 'User berhasil dihapus']);
    }
}

