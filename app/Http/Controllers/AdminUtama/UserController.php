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
        $query = User::with([
            'siswa.kelas',
            'pembimbing',
            'adminJurusan.jurusan'
        ])
        ->whereNotIn('role', ['Admin Utama'])
        ->orderBy('created_at', 'desc');

        $role = request('role');
        $status = request('status');

        if (!empty($role)) {
            $query->where('role', $role);
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        $users = $query->paginate(10);

        $formatted = $users->getCollection()->map(function ($user) {
            $userData = [
                'id' => $user->id,
                'username' => $user->username,
                'role' => $user->role,
                'email' => $user->email,
                'status' => $user->status
            ];

            switch ($user->role) {
                case 'Siswa':
                    if ($user->siswa) {
                        $userData['detail'] = [
                            'nama' => $user->siswa->nama,
                            'nis' => $user->siswa->nis,
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

        $users->setCollection($formatted);

        return view('admin_utama.user', [
            'users' => $users,
            'jurusans' => Jurusan::all(),
            'kelas' => Kelas::whereHas('tahunAjar', function($query) {
                $query->where('status', 'Aktif');
            })->get()
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            if (!$request->filled('roleUser')) {
                return response()->json([
                    'success' => false,
                    'errors' => ['roleUser' => ['Silakan pilih peran pengguna']]
                ], 422);
            }

            if (!$request->filled('namaUser')) {
                return response()->json([
                    'success' => false,
                    'errors' => ['namaUser' => ['Nama pengguna harus diisi']]
                ], 422);
            }
            $request->validate([
                'roleUser' => 'required|in:Siswa,Guru,Admin Jurusan',
                'namaUser' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:tbl_users,username',
                    'regex:/^[a-zA-Z0-9._-]+$/', 
                ],
            ],[
                'namaUser.unique' => 'Nama pengguna sudah ada sebelumnya',
                'namaUser.regex' => 'Nama pengguna tidak boleh mengandung spasi atau karakter khusus selain titik, garis bawah, dan tanda hubung',
            ]);

            $user = User::create([
                'username' => $request->namaUser,
                'password' => bcrypt('123456'),
                'role' => $request->roleUser,
                'status' => User::STATUS_PENDING,
                'is_default_password' => true,
            ]);

            if ($request->roleUser == 'Siswa') {
                if (!$request->filled('namaSiswa')) {
                    return response()->json(['success' => false, 'errors' => ['namaSiswa' => 'Nama siswa harus diisi']], 422);
                }

                if (!$request->filled('nisSiswa')) {
                    return response()->json(['success' => false, 'errors' => ['nisSiswa' => 'NIS siswa harus diisi']], 422);
                }

                if (Siswa::where('nis', $request->nisSiswa)->exists()) {
                    return response()->json(['success' => false, 'errors' => ['nisSiswa' => 'NIS yang digunakan sudah ada sebelumnya']], 422);
                }

                if (!$request->filled('kelasSiswa')) {
                    return response()->json(['success' => false, 'errors' => ['kelasSiswa' => 'Kelas siswa harus dipilih']], 422);
                }

                $siswa = Siswa::create([
                    'user_id' => $user->id,
                    'nama' => $request->namaSiswa,
                    'nis' => $request->nisSiswa,
                    'kelas_id' => $request->kelasSiswa,
                ]);

                if (!$siswa) {
                    throw new \Exception('Gagal menyimpan data siswa');
                }
            } 
            elseif ($request->roleUser == 'Guru') {
                if (!$request->filled('namaGuru')) {
                    return response()->json(['success' => false, 'errors' => ['namaGuru' => 'Nama guru harus diisi']], 422);
                }

                if (!$request->filled('nipGuru')) {
                    return response()->json(['success' => false, 'errors' => ['nipGuru' => 'NIP guru harus diisi']], 422);
                }

                if (Pembimbing::where('nip', $request->nipGuru)->exists()) {
                    return response()->json(['success' => false, 'errors' => ['nipGuru' => 'NIP yang digunakan sudah ada sebelumnya']], 422);
                }

                if (!$request->filled('telpGuru')) {
                    return response()->json(['success' => false, 'errors' => ['telpGuru' => 'Nomor telepon guru harus diisi']], 422);
                }

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
                if (!$request->filled('namaAdm')) {
                    return response()->json(['success' => false, 'errors' => ['namaAdm' => 'Nama admin jurusan harus diisi']], 422);
                }

                if (AdminJurusan::where('nama', $request->namaAdm)->exists()) {
                    return response()->json(['success' => false, 'errors' => ['namaAdm' => 'Nama admin jurusan yang digunakan sudah ada sebelumnya']], 422);
                }

                if (!$request->filled('jurusanAdm')) {
                    return response()->json(['success' => false, 'errors' => ['jurusanAdm' => 'Jurusan harus dipilih']], 422);
                }

                $existingAdmin = AdminJurusan::where('jurusan_id', $request->jurusanAdm)->first();
                if ($existingAdmin) {
                    return response()->json([
                        'success' => false,
                        'errors' => ['jurusan' => 'Jurusan ini sudah memiliki admin jurusan']
                    ], 422);
                }

                $adminJurusan = AdminJurusan::create([
                    'user_id' => $user->id,
                    'nama' => $request->namaAdm,
                    'jurusan_id' => $request->jurusanAdm,
                ]);

                if (!$adminJurusan) {
                    throw new \Exception('Gagal menyimpan data admin jurusan');
                }
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Pengguna berhasil ditambahkan!']);

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
        $user = User::with(['siswa', 'pembimbing', 'adminJurusan'])->findOrFail($id);

        try {
            if (!$request->filled('namaUser')) {
                return response()->json([
                    'success' => false,
                    'errors' => ['namaUser' => ['Nama pengguna harus diisi']]
                ], 422);
            }
            $request->validate([
                'namaUser' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:tbl_users,username,' . $id,
                    'regex:/^[a-zA-Z0-9._-]+$/',
                ],
            ], [
                'namaUser.unique' => 'Nama pengguna sudah ada sebelumnya',
                'namaUser.regex' => 'Nama pengguna tidak boleh mengandung spasi atau karakter khusus selain titik, garis bawah, dan tanda hubung',
            ]);
            
            $user->update([
                'username' => $request->namaUser,
            ]);
    
            if ($request->roleUser == 'Siswa') {

                if (!$request->filled('namaSiswa')) {
                    return response()->json(['success' => false, 'errors' => ['namaSiswa' => ['Nama siswa harus diisi']]], 422);
                }

                if (!$request->filled('nisSiswa')) {
                    return response()->json(['success' => false, 'errors' => ['nisSiswa' => ['NIS siswa harus diisi']]], 422);
                }

                if (Siswa::where('nis', $request->nisSiswa)->where('user_id', '!=', $user->id)->exists()) {
                    return response()->json(['success' => false, 'errors' => ['nisSiswa' => ['NIS sudah digunakan']]], 422);
                }

                if (!$request->filled('kelasSiswa')) {
                    return response()->json(['success' => false, 'errors' => ['kelasSiswa' => ['Kelas siswa harus dipilih']]], 422);
                }

                $user->siswa = Siswa::where('user_id', $user->id)->firstOrFail();

                $user->siswa->update([
                    'nama' => $request->namaSiswa,
                    'nis' => $request->nisSiswa,
                    'kelas_id' => $request->kelasSiswa,
                ]);

            } elseif ($request->roleUser == 'Guru') {
                if (!$request->filled('namaGuru')) {
                    return response()->json(['success' => false, 'errors' => ['namaGuru' => ['Nama guru harus diisi']]], 422);
                }

                if (!$request->filled('nipGuru')) {
                    return response()->json(['success' => false, 'errors' => ['nipGuru' => ['NIP guru harus diisi']]], 422);
                }

                if (Pembimbing::where('nip', $request->nipGuru)->where('user_id', '!=', $user->id)->exists()) {
                    return response()->json(['success' => false, 'errors' => ['nipGuru' => ['NIP sudah digunakan']]], 422);
                }

                if (!$request->filled('telpGuru')) {
                    return response()->json(['success' => false, 'errors' => ['telpGuru' => ['Nomor telepon guru harus diisi']]], 422);
                }

                $user->pembimbing = Pembimbing::where('user_id', $user->id)->firstOrFail();

                $user->pembimbing->update([
                    'nama' => $request->namaGuru,
                    'nip' => $request->nipGuru,
                    'telp' => $request->telpGuru,
                ]);

            } elseif ($request->roleUser == 'Admin Jurusan') {
                if (!$request->filled('namaAdm')) {
                    return response()->json(['success' => false, 'errors' => ['namaAdm' => ['Nama admin harus diisi']]], 422);
                }

                if (AdminJurusan::where('nama', $request->namaAdm)->where('user_id', '!=', $user->id)->exists()) {
                    return response()->json(['success' => false, 'errors' => ['namaAdm' => ['Nama admin sudah digunakan']]], 422);
                }

                if (!$request->filled('jurusanAdm')) {
                    return response()->json(['success' => false, 'errors' => ['jurusanAdm' => ['Jurusan harus dipilih']]], 422);
                }

                $existingAdmin = AdminJurusan::where('jurusan_id', $request->jurusanAdm)
                    ->where('id', '!=', $user->adminJurusan->id)
                    ->first();
                if ($existingAdmin) {
                    return response()->json([
                        'success' => false,
                        'errors' => ['jurusan' => ['Jurusan ini sudah memiliki admin jurusan.']]
                    ], 422);
                }

                $user->adminJurusan = AdminJurusan::where('user_id', $user->id)->firstOrFail();

                $user->adminJurusan->update([
                    'nama' => $request->namaAdm,
                    'jurusan_id' => $request->jurusanAdm,
                ]);
            }
    
            return response()->json(['success' => true, 'message' => 'Pengguna berhasil diperbarui']);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->role == 'Siswa' && $user->siswa) {
            $user->siswa->delete();
        } elseif ($user->role == 'Guru' && $user->pembimbing) {
            $user->pembimbing->delete();
        } elseif ($user->role == 'Admin Jurusan' && $user->adminJurusan) {
            $user->adminJurusan->delete();
        }

        $user->delete();

        return response()->json(['success' => true, 'message' => 'Pengguna berhasil dihapus']);
    }
}

