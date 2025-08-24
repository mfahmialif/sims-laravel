<?php
namespace App\Http\Controllers\Guru;

use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Jadwal;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TahunPelajaran;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{

    public function index()
    {
        $tahunPelajaran = TahunPelajaran::orderBy('kode', 'desc')->get();
        $kelas          = Kelas::orderBy('angka', 'asc')->get();
        return view('guru.nilai.index', compact('tahunPelajaran', 'kelas'));
    }

    public function data(Request $request)
    {
        $guru = Auth::user()->guru;
        $search = request('search.value');

        $data = Jadwal::join('tahun_pelajaran', 'tahun_pelajaran.id', '=', 'jadwal.tahun_pelajaran_id')
            ->join('kurikulum_detail', 'kurikulum_detail.id', '=', 'jadwal.kurikulum_detail_id')
            ->join('kurikulum', 'kurikulum.id', '=', 'kurikulum_detail.kurikulum_id')
            ->join('mata_pelajaran', 'mata_pelajaran.id', '=', 'kurikulum_detail.mata_pelajaran_id')
            ->join('kelas_sub', 'kelas_sub.id', '=', 'jadwal.kelas_sub_id')
            ->join('kelas', 'kelas.id', '=', 'kelas_sub.kelas_id')
            ->join('guru', 'guru.id', '=', 'jadwal.guru_id')
            ->where('jadwal.guru_id', $guru->id)
            ->select(
                'jadwal.*',
                'tahun_pelajaran.kode as tahun_pelajaran_kode',
                'kelas_sub.sub as kelas_sub',
                'kelas.angka as kelas_angka',
                'guru.nama as guru_nama',
                'guru.nip as guru_nip',
                'guru.nik as guru_nik',
                'mata_pelajaran.nama as mata_pelajaran_nama',
                'mata_pelajaran.kode as mata_pelajaran_kode',
                'kurikulum.nama as kurikulum_nama'
            );

        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->when($request->tahun_pelajaran_id, function ($q) use ($request) {
                    $q->where('jadwal.tahun_pelajaran_id', $request->tahun_pelajaran_id);
                });
                $query->when($request->kelas_id, function ($q) use ($request) {
                    $q->where('kelas.id', $request->kelas_id);
                });
                $query->where(function ($query) use ($search) {
                    $query->orWhere('mata_pelajaran.kode', 'LIKE', "%$search%");
                    $query->orWhere('mata_pelajaran.nama', 'LIKE', "%$search%");
                    $query->orWhere('tahun_pelajaran.nama', 'LIKE', "%$search%");
                    $query->orWhere('tahun_pelajaran.kode', 'LIKE', "%$search%");
                    $query->orWhere('guru.nama', 'LIKE', "%$search%");
                    $query->orWhere('guru.nik', 'LIKE', "%$search%");
                    $query->orWhere('guru.nip', 'LIKE', "%$search%");
                    $query->orWhere('kurikulum.nama', 'LIKE', "%$search%");
                });
            })
            ->editColumn('kelas_angka', function ($row) {
                return $row->kelas_angka . ' ' . $row->kelas_sub;
            })
            ->editColumn('mata_pelajaran_nama', function ($row) {
                $kode      = e($row->mata_pelajaran_kode);
                $nama      = e($row->mata_pelajaran_nama);
                $kurikulum = e($row->kurikulum_nama);

                return '
                    <div class="fw-bold">' . $kode . ' / ' . $nama . '</div>
                    <small class="text-muted">' . $kurikulum . '</small>
                ';
            })
            ->editColumn('guru_nama', function ($row) {
                $nama = e($row->guru_nama);
                $nip  = e($row->nip);
                $nik  = e($row->nik);

                return '
                    <div class="fw-bold">' . $nama . '</div>
                    <small class="text-muted">NIP: ' . $nip . '<br>NIK: ' . $nik . '</small>
                ';
            })
            ->editColumn('hari', function ($row) {
                $hari       = e($row->hari);
                $jamMulai   = e(substr($row->jam_mulai, 0, 5)); // contoh: '07:30:00' -> '07:30'
                $jamSelesai = e(substr($row->jam_selesai, 0, 5));

                return '
                    <div class="fw-bold">' . $hari . '</div>
                    <small class="text-muted">' . $jamMulai . ' - ' . $jamSelesai . '</small>
                ';
            })
            ->addColumn('action', function ($row) {
                $content = '<div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="' . route("guru.nilai.bobot-nilai.index", ['jadwal' => $row]) . '"><i class="fa-solid fa-eye m-r-5"></i> Bobot Nilai</a>
                            <a class="dropdown-item" href="' . route("guru.nilai.input.index", ['jadwal' => $row]) . '"><i class="fa-solid fa-pen m-r-5"></i> Input Nilai</a>
                        </div>
                    </div>';
                return $content;
            })
            ->rawColumns(['action', 'kelas_angka', 'mata_pelajaran_nama', 'guru_nama', 'hari'])
            ->toJson();
    }
}
