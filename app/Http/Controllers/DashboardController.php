<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\DudiJurusan;
use App\Models\PenetapanPrakerin;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        // Data umum untuk semua user
        $data = [
            'role' => $role,
        ];

        switch ($role) {
            case User::ROLE_ADMIN_UTAMA:
                $data['totalUsers'] = User::where('status', 'Aktif')->where('role', '!=', User::ROLE_ADMIN_UTAMA)->count();
                $data['totalJurusan'] = Jurusan::count();
                $data['totalKelas'] = Kelas::count();
                break;

            case User::ROLE_ADMIN_JURUSAN:
                // Menghitung total siswa berdasarkan jurusan yang diambil dari kelas
    
                $data['totalSiswa'] = Siswa::join('tbl_kelas', 'tbl_siswa.kelas_id', '=', 'tbl_kelas.id')
                ->where('tbl_kelas.jurusan_id', $user->adminJurusan->jurusan_id
                )
                ->count();

                // Menghitung total lokasi prakerin berdasarkan siswa yang ada di jurusan        
                $data['totalLokasiPrakerin'] = DudiJurusan::whereHas('siswa.kelas', function ($query) use ($user) {
                    $query->where('jurusan_id', $user->adminJurusan->jurusan_id);
                })->count();
                break;

            case User::ROLE_GURU:
                $pembimbing = $user->pembimbing;
                // Total siswa bimbingan dari penetapan prakerin
                $data['totalSiswaBimbingan'] = PenetapanPrakerin::whereHas('dudiJurusan', function ($query) use ($pembimbing) {
                    $query->where('pembimbing_id', $pembimbing->id);
                })->count();
            
                $data['totalLokasiPrakerin'] = DudiJurusan::where('pembimbing_id', $pembimbing->id)
                    ->distinct('id')
                    ->count('id');

                break;
                
            default:
                return redirect()->route('login')->with('error', 'Akses tidak diizinkan');
        }

        return view('dashboard', $data);
    }
}