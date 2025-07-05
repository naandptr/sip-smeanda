<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\DudiJurusan;
use App\Models\PenetapanPrakerin;
use App\Models\TahunAjar;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

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
                $jurusanId = $user->adminJurusan->jurusan_id;

                $data['totalSiswa'] = Siswa::join('tbl_kelas', 'tbl_siswa.kelas_id', '=', 'tbl_kelas.id')
                    ->where('tbl_kelas.jurusan_id', $jurusanId)->count();

                $data['totalLokasiPrakerin'] = DudiJurusan::where('jurusan_id', $jurusanId)->count();

                $tahunAjaranTersedia = TahunAjar::orderBy('tahun_ajaran', 'asc')->get()->values();

                $tahunAjaranTerakhir = $tahunAjaranTersedia->take(3)->sortBy('tahun_ajaran')->values();

                $defaultTahunAwal = $tahunAjaranTerakhir->first()?->tahun_ajaran;
                $defaultTahunAkhir = $tahunAjaranTerakhir->last()?->tahun_ajaran;


                $tahunAwal = $defaultTahunAwal;
                $tahunAkhir = $defaultTahunAkhir;

                $data['semuaTahunAjaran'] = $tahunAjaranTersedia;

                $labels = [];
                $chartData = [];

                foreach ($tahunAjaranTersedia->whereBetween('tahun_ajaran', [$defaultTahunAwal, $defaultTahunAkhir]) as $tahun) {
                    $jumlah = PenetapanPrakerin::where('tahun_ajar_id', $tahun->id)
                        ->whereHas('siswa.kelas', fn ($q) => $q->where('jurusan_id', $jurusanId))
                        ->count();

                    $labels[] = $tahun->tahun_ajaran;
                    $chartData[] = $jumlah;
                }

                $penetapanDudi = DudiJurusan::where('jurusan_id', $jurusanId)
                    ->with(['dudi', 'penetapanPrakerin.siswa.kelas', 'penetapanPrakerin.tahunAjar'])
                    ->get()
                    ->map(function ($dudi) use ($jurusanId, $tahunAwal, $tahunAkhir) {
                        $siswaUnik = $dudi->penetapanPrakerin
                            ->filter(function ($penetapan) use ($jurusanId, $tahunAwal, $tahunAkhir) {
                                return
                                    $penetapan->siswa &&
                                    $penetapan->siswa->kelas &&
                                    $penetapan->siswa->kelas->jurusan_id == $jurusanId &&
                                    $penetapan->tahunAjar &&
                                    $penetapan->tahunAjar->tahun_ajaran >= $tahunAwal &&
                                    $penetapan->tahunAjar->tahun_ajaran <= $tahunAkhir;
                            })
                            ->pluck('siswa.id')
                            ->unique()
                            ->count();

                        return [
                            'dudi' => $dudi->dudi->nama_dudi,
                            'jumlah_siswa' => $siswaUnik
                        ];
                    });

                $data['chartLabels'] = $labels;
                $data['chartData'] = $chartData;
                $data['chartLabelsDudi'] = $penetapanDudi->pluck('dudi');
                $data['chartDataDudi'] = $penetapanDudi->pluck('jumlah_siswa');

                break;

            case User::ROLE_SISWA:
                $siswa = Siswa::with([
                    'penetapanPrakerin.dudiJurusan.dudi',
                    'penetapanPrakerin.dudiJurusan.pembimbing'
                ])->where('user_id', $user->id)->first();
            
                $penetapan = $siswa->penetapanPrakerin->sortByDesc('tanggal_mulai')->first();
            
                $data['siswa'] = $siswa;
                $data['penetapan'] = $penetapan;
                break;
                
            default:
                return redirect()->route('login')->with('error', 'Akses tidak diizinkan');
        }

        return view('dashboard', $data);
    }
    
    public function chartData(Request $request)
    {
        $user = Auth::user();
        $jurusanId = $user->adminJurusan->jurusan_id;

        $tahunAwal = $request->get('tahun_awal');
        $tahunAkhir = $request->get('tahun_akhir');

        $queryTahun = TahunAjar::query();

        if ($tahunAwal) {
            $queryTahun->where('tahun_ajaran', '>=', $tahunAwal);
        }

        if ($tahunAkhir) {
            $queryTahun->where('tahun_ajaran', '<=', $tahunAkhir);
        }

        $tahunAjaran = $queryTahun->orderBy('tahun_ajaran')->get();

        $labels = [];
        $penetapanData = [];

        foreach ($tahunAjaran as $tahun) {
            $jumlah = PenetapanPrakerin::where('tahun_ajar_id', $tahun->id)
                ->whereHas('siswa.kelas', fn ($q) => $q->where('jurusan_id', $jurusanId))
                ->count();

            $labels[] = $tahun->tahun_ajaran;
            $penetapanData[] = $jumlah;
        }

        $tahunAjarIds = $tahunAjaran->pluck('id');

        $penetapanDudi = DudiJurusan::withCount(['penetapanPrakerin as total_siswa' => function ($q) use ($jurusanId, $tahunAjarIds) {
            $q->whereHas('siswa.kelas', fn ($q2) => $q2->where('jurusan_id', $jurusanId))
            ->whereIn('tahun_ajar_id', $tahunAjarIds);
        }])
        ->with('dudi')
        ->where('jurusan_id', $jurusanId)
        ->get();

        return response()->json([
            'chart1' => [
                'labels' => $labels,
                'data' => $penetapanData,
            ],
            'chart2' => [
                'labels' => $penetapanDudi->pluck('dudi.nama_dudi'),
                'data' => $penetapanDudi->pluck('total_siswa'),
            ]
        ]);
    }
}