<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Helper;
use App\Models\BobotNilai;
use App\Models\Jadwal;
use App\Models\KomponenNilai;
use App\Models\Nilai;
use App\Models\NilaiDetail;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class NilaiInputController extends Controller
{
    private $rules = [
        'nilai' => 'required',
    ];

    public function index(Jadwal $jadwal)
    {
        $komponenNilai = KomponenNilai::orderBy('jenis', 'asc')->get();

        // Ambil semua bobot nilai untuk jadwal ini
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

        return view('admin.nilai.input.index', compact('jadwal', 'kelompokKomponen'));
    }
    public function dataForm(Request $request)
    {
        $jadwal = Jadwal::findOrFail(request()->route('jadwal'));
        $search = request('search.value');
        $data   = Siswa::join('tahun_pelajaran', 'tahun_pelajaran.id', '=', 'siswa.tahun_pelajaran_id')
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
            ->select('siswa.*', 'tahun_pelajaran.kode as tahun_pelajaran_kode', 'kelas.angka as kelas_angka', 'kelas_sub.sub as kelas_sub');

        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->when($request->tahun_pelajaran_id, function ($q) use ($request) {
                    $q->where('siswa.tahun_pelajaran_id', $request->tahun_pelajaran_id);
                });
                $query->when($request->jenis_kelamin, function ($q) use ($request) {
                    $q->where('siswa.jenis_kelamin', $request->jenis_kelamin);
                });
                $query->when($request->kelas_id, function ($q) use ($request) {
                    $q->where('siswa.kelas_id', $request->kelas_id);
                });
                $query->where(function ($query) use ($search) {
                    $query->orWhere('siswa.nama_siswa', 'LIKE', "%$search%");
                    $query->orWhere('siswa.jenis_kelamin', 'LIKE', "%$search%");
                    $query->orWhere('siswa.nis', 'LIKE', "%$search%");
                    $query->orWhere('siswa.nisn', 'LIKE', "%$search%");
                    $query->orWhere('siswa.nik_anak', 'LIKE', "%$search%");
                });
            })
            ->editColumn('nama_siswa', function ($row) {
                $row->foto = $row->foto ? asset('foto_siswa/' . $row->foto) : asset('template/assets/img/user.jpg');
                return '
                    <div class="d-flex align-items-center">
                        <img src="' . $row->foto . '" alt="Foto Siswa" class="rounded-circle me-2" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <a href="' . route("admin.siswa.show", $row) . '">' . $row->nama_siswa . '</a><br>
                            <small>NIS: ' . ($row->nis ?? '-') . '</small><br>
                            <small>Kelas: ' . ($row->kelas_angka ?? '-') . ' ' . ($row->kelas_sub ?? '-') . '</small><br>
                            <small>' . ($row->jenis_kelamin ?? '-') . '</small>
                        </div>
                    </div>
                ';
            })
            ->editColumn('status', function ($row) {
                return '<span class="badge bg-' . Helper::getColorStatus($row->status) . '">' . strtoupper($row->status) . '</span>';
            })
            ->rawColumns(['nama_siswa', 'status'])
            ->escapeColumns()
            ->toJson();
    }

    public function store(Jadwal $jadwal, Request $request)
    {
        try {
            $request->validate($this->rules,
                [
                    'nilai.required' => 'Harus ada nilai yang diisi.',
                ]);

            \DB::beginTransaction();

            Nilai::where('jadwal_id', $jadwal->id)->delete();
            NilaiDetail::where('jadwal_id', $jadwal->id)->delete();

            $nilaiDetail = [];
            foreach ($request->nilai as $siswaId => $nilai) {
                foreach ($nilai as $komponenNilaiId => $value) {
                    $nilaiDetail[] = [
                        'siswa_id'          => $siswaId,
                        'jadwal_id'         => $jadwal->id,
                        'komponen_nilai_id' => $komponenNilaiId,
                        'nilai'             => $value,
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ];
                }
            }
            NilaiDetail::insert($nilaiDetail);

            $komponenNilai    = KomponenNilai::orderBy('jenis', 'asc')->get();
            $bobotNilai       = BobotNilai::where('jadwal_id', $jadwal->id)->get()->keyBy('komponen_nilai_id');
            $kelompokKomponen = [];
            foreach ($komponenNilai as $item) {
                $kelompokKomponen[$item->jenis][] = [
                    'id'    => $item->id,
                    'nama'  => $item->nama,
                    'bobot' => optional($bobotNilai[$item->id] ?? null)->bobot ?? null,
                ];
            }

            $nilaiInsert = [];
            foreach ($request->nilai as $siswaId => $nilai) {
                foreach ($kelompokKomponen as $jenis => $komponen) {
                    if ($jenis === 'sikap') {
                        continue;
                    }
                    $nilaiPerJenis = 0;
                    foreach ($komponen as $item) {
                        $nilaiTemp = ($item['bobot'] / 100) * $nilai[$item['id']] ?? 0;
                        $nilaiPerJenis += $nilaiTemp;
                    }
                    $nilaiInsert[] = [
                        'siswa_id'    => $siswaId,
                        'jadwal_id'   => $jadwal->id,
                        'jenis'       => $jenis,
                        'nilai_akhir' => $nilaiPerJenis,
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ];
                }
            }

            Nilai::insert($nilaiInsert);

            \DB::commit();
            return redirect()->route('admin.nilai.index')->with('success', 'Absensi berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd(implode(' ', collect($e->errors())->flatten()->toArray()));
            return redirect()->route('admin.nilai.input.index', ['jadwal' => $jadwal])
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            \DB::rollback();
            return redirect()->route('admin.nilai.input.index', ['jadwal' => $jadwal])->with('error', $th->getMessage())->withInput();
        }

    }
}
