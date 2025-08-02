<?php
namespace App\Http\Controllers\Admin;

use App\Exports\ExcelViewExport;
use App\Http\Controllers\Controller;
use App\Http\Services\Helper;
use App\Models\BobotNilai;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\KomponenNilai;
use App\Models\Siswa;
use App\Models\TahunPelajaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class CetakLaporanController extends Controller
{
    public function index()
    {
        $tahunPelajaran = TahunPelajaran::orderBy('kode', 'desc')->get();
        $kelas          = Kelas::orderBy('angka', 'asc')->get();
        return view('admin.cetak-laporan.index', compact('tahunPelajaran', 'kelas'));
    }

    public function data(Request $request)
    {
        $search = request('search.value');

        $data = Jadwal::join('tahun_pelajaran', 'tahun_pelajaran.id', '=', 'jadwal.tahun_pelajaran_id')
            ->join('kurikulum_detail', 'kurikulum_detail.id', '=', 'jadwal.kurikulum_detail_id')
            ->join('kurikulum', 'kurikulum.id', '=', 'kurikulum_detail.kurikulum_id')
            ->join('mata_pelajaran', 'mata_pelajaran.id', '=', 'kurikulum_detail.mata_pelajaran_id')
            ->join('kelas_sub', 'kelas_sub.id', '=', 'jadwal.kelas_sub_id')
            ->join('kelas', 'kelas.id', '=', 'kelas_sub.kelas_id')
            ->join('guru', 'guru.id', '=', 'jadwal.guru_id')
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
                            <a class="dropdown-item" href="' . route("admin.cetak-laporan.cetakNilai", ['jadwal_id' => $row, 'submit' => 'excel']) . '"><i class="fa-solid fa-file-excel m-r-5"></i> Nilai Excel</a>
                            <a class="dropdown-item" href="' . route("admin.cetak-laporan.cetakNilai", ['jadwal_id' => $row, 'submit' => 'pdf']) . '"><i class="fa-solid fa-file-pdf m-r-5"></i> Nilai PDF</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="' . route("admin.cetak-laporan.cetakAbsensi", ['jadwal_id' => $row, 'submit' => 'excel']) . '"><i class="fa-solid fa-file-excel m-r-5"></i> Absensi Excel</a>
                            <a class="dropdown-item" href="' . route("admin.cetak-laporan.cetakAbsensi", ['jadwal_id' => $row, 'submit' => 'pdf']) . '"><i class="fa-solid fa-file-pdf m-r-5"></i> Absensi PDF</a>
                        </div>
                    </div>';
                return $content;
            })
            ->rawColumns(['action', 'kelas_angka', 'mata_pelajaran_nama', 'guru_nama', 'hari'])
            ->toJson();
    }

    public function cetakNilai(Request $request)
    {
        $jadwal = Jadwal::findOrFail($request->jadwal_id);

        $data = Siswa::join('tahun_pelajaran', 'tahun_pelajaran.id', '=', 'siswa.tahun_pelajaran_id')
            ->join('kelas', 'kelas.id', '=', 'siswa.kelas_id')
            ->join('kelas_sub', 'kelas_sub.kelas_id', '=', 'kelas.id')
            ->join('kelas_siswa', 'kelas_siswa.siswa_id', '=', 'siswa.id')
            ->where('status_daftar', 'diterima')
            ->where('kelas_siswa.kelas_sub_id', $jadwal->kelas_sub_id)
            ->where('siswa.kurikulum_id', $jadwal->kurikulumDetail->kurikulum_id)
            ->with([
                'nilai'       => function ($query) use ($jadwal) {
                    $query->where('jadwal_id', $jadwal->id);
                },
                'nilaiDetail' => function ($query) use ($jadwal) {
                    $query->where('jadwal_id', $jadwal->id);
                },
            ])
            ->select('siswa.*', 'tahun_pelajaran.kode as tahun_pelajaran_kode', 'kelas.angka as kelas_angka', 'kelas_sub.sub as kelas_sub')
            ->get();

        $komponenNilai = KomponenNilai::all();
        $jenis         = Helper::getEnumValues('komponen_nilai', 'jenis');

        $komponenNilai = KomponenNilai::orderBy('jenis', 'asc')->get();

        $bobotNilai = BobotNilai::where('jadwal_id', $jadwal->id)->get()->keyBy('komponen_nilai_id');

        $kelompokKomponen = [];

        foreach ($komponenNilai as $item) {
            $kelompokKomponen[$item->jenis][] = [
                'id'    => $item->id,
                'nama'  => $item->nama,
                'bobot' => optional($bobotNilai[$item->id] ?? null)->bobot ?? null,
            ];
        }

        foreach ($kelompokKomponen as $jenis => $komponen) {
            if ($jenis !== 'sikap') {
                $kelompokKomponen[$jenis][count($komponen)] = [
                    'id'    => null,
                    'nama'  => 'Nilai',
                    'bobot' => null,
                ];
            }
        }

        if ($request->submit == 'excel') {
            return Excel::download(new ExcelViewExport(
                compact('data', 'komponenNilai', 'jenis', 'kelompokKomponen'),
                'admin.cetak-laporan.nilai.excel'
            ),
                'cetak-nilai.xlsx');
        } else {
            $pdf = Pdf::loadView('admin.cetak-laporan.nilai.pdf', compact('data', 'komponenNilai', 'jenis', 'kelompokKomponen', 'jadwal'));
            return $pdf->stream('cetak nilai.pdf');
        }
    }

    public function cetakAbsensi(Request $request)
    {
        $jadwal = Jadwal::findOrFail($request->jadwal_id);
        $data   = Siswa::join('tahun_pelajaran', 'tahun_pelajaran.id', '=', 'siswa.tahun_pelajaran_id')
            ->join('kelas', 'kelas.id', '=', 'siswa.kelas_id')
            ->join('kelas_sub', 'kelas_sub.kelas_id', '=', 'kelas.id')
            ->join('kelas_siswa', 'kelas_siswa.siswa_id', '=', 'siswa.id')
            ->where('status_daftar', 'diterima')
            ->where('kelas_siswa.kelas_sub_id', $jadwal->kelas_sub_id)
            ->where('siswa.kurikulum_id', $jadwal->kurikulumDetail->kurikulum_id)
            ->select('siswa.*', 'tahun_pelajaran.kode as tahun_pelajaran_kode', 'kelas.angka as kelas_angka', 'kelas_sub.sub as kelas_sub')
            ->get();

        $pertemuan = [
            'jumlah' => 16,
            'uts' => 8,
            'uas' => 16
        ];

        if ($request->submit == 'excel') {
            return Excel::download(new ExcelViewExport(
                compact('data', 'jadwal', 'pertemuan'),
                'admin.cetak-laporan.absensi.excel'
            ),
                'cetak-absensi.xlsx');
        } else {
            $pdf = Pdf::loadView('admin.cetak-laporan.absensi.pdf', compact('data', 'jadwal', 'pertemuan'));
            return $pdf->stream('cetak absensi.pdf');
        }
    }
}
