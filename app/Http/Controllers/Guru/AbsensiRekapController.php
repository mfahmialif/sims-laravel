<?php
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Http\Services\Helper;
use App\Models\Absensi;
use App\Models\AbsensiDetail;
use App\Models\Jadwal;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class AbsensiRekapController extends Controller
{
    private $rules = [
        'keterangan' => 'nullable',
        'tanggal'    => 'required',
        'data'       => 'required',
    ];

    public function index(Jadwal $jadwal)
    {
        return view('guru.absensi.rekap.index', compact('jadwal'));
    }

    public function data(Request $request)
    {
        $jadwal = Jadwal::findOrFail(request()->route('jadwal'));
        $search = request('search.value');
        $data   = Absensi::where('jadwal_id', $jadwal->id);
        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('keterangan', 'LIKE', "%$search%");
                    $query->orWhere('tanggal', 'LIKE', "%$search%");
                });
            })
            ->addColumn('action', function ($row) use ($jadwal) {
                $content = '<div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="' . route("guru.absensi.rekap.edit", ['jadwal' => $jadwal, 'absensi' => $row]) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
                            <form action="" onsubmit="deleteData(event)" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" name="id" value="' . $row->id . '">
                                <input type="hidden" name="nama" value="' . Str::limit($row->keterangan, 20) . '">
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fa fa-trash-alt m-r-5"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>';
                return $content;
            })
            ->rawColumns(['action', 'name'])
            ->toJson();
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
            ->where('kelas_sub.id', $jadwal->kelas_sub_id)
            ->where('kelas_siswa.kelas_sub_id', $jadwal->kelas_sub_id)
            ->where('siswa.kurikulum_id', $jadwal->kurikulumDetail->kurikulum_id)
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
                            <span>' . $row->nama_siswa . '</span><br>
                            <small>NIS: ' . ($row->nis ?? '-') . '</small><br>
                            <small>Kelas: ' . ($row->kelas_angka ?? '-') . ' ' . ($row->kelas_sub ?? '-') . '</small><br>
                            <small>' . ($row->jenis_kelamin ?? '-') . '</small><br>
                            <small>' . ($row->kurikulum->nama ?? '-') . '</small>
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

    public function dataFormEdit(Request $request)
    {
        $jadwal  = Jadwal::findOrFail(request()->route('jadwal'));
        $absensi = Absensi::findOrFail(request()->route('absensi'));

        $search = request('search.value');
        $data   = Siswa::join('tahun_pelajaran', 'tahun_pelajaran.id', '=', 'siswa.tahun_pelajaran_id')
            ->join('kelas', 'kelas.id', '=', 'siswa.kelas_id')
            ->join('kelas_sub', 'kelas_sub.kelas_id', '=', 'kelas.id')
            ->leftJoin('absensi_detail', 'absensi_detail.siswa_id', '=', 'siswa.id')
            ->join('kelas_siswa', 'kelas_siswa.siswa_id', '=', 'siswa.id')
            ->where('status_daftar', 'diterima')
            ->where('kelas_sub.id', $jadwal->kelas_sub_id)
            ->where('kelas_siswa.kelas_sub_id', $jadwal->kelas_sub_id)
            ->where('siswa.kurikulum_id', $jadwal->kurikulumDetail->kurikulum_id)
            ->where('absensi_detail.absensi_id', $absensi->id)
            ->select('siswa.*', 'tahun_pelajaran.kode as tahun_pelajaran_kode', 'kelas.angka as kelas_angka', 'kelas_sub.sub as kelas_sub', 'absensi_detail.status as absensi_detail_status');
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
                            <span>' . $row->nama_siswa . '</span><br>
                            <small>NIS: ' . ($row->nis ?? '-') . '</small><br>
                            <small>Kelas: ' . ($row->kelas_angka ?? '-') . ' ' . ($row->kelas_sub ?? '-') . '</small><br>
                            <small>' . ($row->jenis_kelamin ?? '-') . '</small><br>
                            <small>' . ($row->kurikulum->nama ?? '-') . '</small>
                        </div>
                    </div>
                ';
            })
            ->rawColumns(['nama_siswa'])
            ->escapeColumns()
            ->toJson();
    }

    public function add(Jadwal $jadwal)
    {
        return view('guru.absensi.rekap.add', compact('jadwal'));
    }

    public function store(Jadwal $jadwal, Request $request)
    {
        try {
            $request->validate($this->rules,
                [
                    'data.required' => 'Absensi mahasiswa harus dipilih.',
                ]);

            \DB::beginTransaction();

            $absensi             = new Absensi();
            $absensi->jadwal_id  = $jadwal->id;
            $absensi->keterangan = $request->keterangan;
            $absensi->tanggal    = $request->tanggal;
            $absensi->save();

            $detail = [];
            foreach ($request->data as $siswaId => $status) {
                $detail[] = [
                    'absensi_id' => $absensi->id,
                    'siswa_id'   => $siswaId,
                    'status'     => $status,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            AbsensiDetail::insert($detail);
            \DB::commit();
            return redirect()->route('guru.absensi.rekap.index', ['jadwal' => $jadwal])->with('success', 'Absensi berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('guru.absensi.rekap.add', ['jadwal' => $jadwal])
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            \DB::rollback();
            return redirect()->route('guru.absensi.rekap.add', ['jadwal' => $jadwal])->with('error', $th->getMessage())->withInput();
        }

    }

    public function edit(Jadwal $jadwal, Absensi $absensi)
    {
        return view('guru.absensi.rekap.edit', compact('absensi', 'jadwal'));
    }

    public function update(Jadwal $jadwal, Absensi $absensi, Request $request)
    {
        try {
            $rules         = $this->rules;
            $rules['data'] = 'nullable|array';

            $request->validate($rules);

            \DB::beginTransaction();

            $absensi->keterangan = $request->keterangan;
            $absensi->tanggal    = $request->tanggal;
            $absensi->save();

            if ($request->data) {
                foreach ($request->data as $siswaId => $status) {
                    AbsensiDetail::where('absensi_id', $absensi->id)->where('siswa_id', $siswaId)->update(['status' => $status]);
                }
            }

            \DB::commit();
            return redirect()->route('guru.absensi.rekap.index', ['jadwal' => $jadwal])->with('success', 'Absensi berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('guru.absensi.rekap.edit', ['jadwal' => $jadwal, 'absensi' => $absensi])
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            \DB::rollback();
            return redirect()->route('guru.absensi.rekap.edit', ['jadwal' => $jadwal, 'absensi' => $absensi])->with('error', $th->getMessage())->withInput();
        }

    }

    public function destroy(Jadwal $jadwal, Absensi $absensi)
    {
        try {
            \DB::beginTransaction();

            AbsensiDetail::where('absensi_id', $absensi->id)->delete();
            $absensi->delete();

            \DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Absensi berhasil dihapus',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollback();
            if ($e->getCode() == '23000') {
                return response()->json([
                    'status'  => false,
                    'message' => 'Absensi tidak dapat dihapus karena masih digunakan oleh user.',
                ]);
            }

            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan pada database: ' . $e->getMessage(),
            ]);
        } catch (\Throwable $th) {
            \DB::rollback();
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage(),
            ]);
        }
    }
}
