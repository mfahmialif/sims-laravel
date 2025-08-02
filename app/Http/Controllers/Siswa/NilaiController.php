<?php
namespace App\Http\Controllers\Siswa;

use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Jadwal;
use App\Models\KelasSub;
use App\Models\NilaiDetail;
use Illuminate\Http\Request;
use App\Http\Services\Helper;
use App\Models\KomponenNilai;
use App\Models\TahunPelajaran;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class NilaiController extends Controller
{
    private $rules = [
        'keterangan' => 'nullable',
    ];

    public function index(KelasSub $kelasSub)
    {
        $tahunPelajaran = TahunPelajaran::orderBy('kode', 'desc')->get();
        $kelas          = Kelas::orderBy('angka', 'asc')->get();
        return view('siswa.nilai.index', compact('tahunPelajaran', 'kelas', 'kelasSub'));
    }

    public function data(KelasSub $kelasSub, Request $request)
    {
        $search = request('search.value');

        $data = Jadwal::join('tahun_pelajaran', 'tahun_pelajaran.id', '=', 'jadwal.tahun_pelajaran_id')
            ->join('kurikulum_detail', 'kurikulum_detail.id', '=', 'jadwal.kurikulum_detail_id')
            ->join('kurikulum', 'kurikulum.id', '=', 'kurikulum_detail.kurikulum_id')
            ->join('mata_pelajaran', 'mata_pelajaran.id', '=', 'kurikulum_detail.mata_pelajaran_id')
            ->join('kelas_sub', 'kelas_sub.id', '=', 'jadwal.kelas_sub_id')
            ->join('kelas', 'kelas.id', '=', 'kelas_sub.kelas_id')
            ->join('guru', 'guru.id', '=', 'jadwal.guru_id')
            ->where('jadwal.kelas_sub_id', $kelasSub->id)
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
                        <a class="dropdown-item" href="' . route("siswa.nilai.show", ['kelasSub' => $row->kelas_sub_id, 'jadwal' => $row]) . '"><i class="fa-solid fa-eye m-r-5"></i> Tampilkan</a>
                        </div>
                    </div>';
                return $content;
            })
            ->rawColumns(['action', 'kelas_angka', 'mata_pelajaran_nama', 'guru_nama', 'hari'])
            ->toJson();
    }

    public function show(KelasSub $kelasSub, Jadwal $jadwal)
    {
        $siswa = \Auth::user()->siswa;
        $jenis         = Helper::getEnumValues('komponen_nilai', 'jenis');
        $komponenNilai = KomponenNilai::orderBy('jenis', 'asc')->get();
        $nilai         = Nilai::where('siswa_id', $siswa->id)->where('jadwal_id', $jadwal->id)->get()->keyBy('jenis');
        $nilaiDetail   = NilaiDetail::join('komponen_nilai', 'komponen_nilai.id', '=', 'nilai_detail.komponen_nilai_id', )
            ->where('nilai_detail.siswa_id', $siswa->id)
            ->where('nilai_detail.jadwal_id', $jadwal->id)
            ->select('nilai_detail.*', 'komponen_nilai.nama as komponen_nilai_nama', 'komponen_nilai.jenis as komponen_nilai_jenis')
            ->get();

        $dataNilaiDetail = [];
        foreach ($nilaiDetail as $key => $value) {
            $dataNilaiDetail[$value->komponen_nilai_jenis][$value->komponen_nilai_id] = $value;
        }

        $dataNilai = [];
        foreach ($jenis as $value) {
            if ($value !== "sikap") {
                $dataNilai[$value]["nilai_akhir"] = $nilai[$value]->nilai_akhir ?? 0;
            }
            $dataNilai[$value]["nilai_detail"] = $komponenNilai->where('jenis', $value)->map(function ($item) use ($dataNilaiDetail, $value) {
                return [
                    'komponen_nilai_nama' => $item->nama,
                    'nilai'               => $dataNilaiDetail[$value][$item->id]->nilai ?? 0,
                ];
            });
        }
        return view('siswa.nilai.show', compact('siswa', 'jadwal', 'nilai', 'jenis', 'dataNilai', 'kelasSub'));

    }
}
