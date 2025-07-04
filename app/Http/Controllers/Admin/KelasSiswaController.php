<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Helper;
use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\KelasSub;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KelasSiswaController extends Controller
{
    private $rules = [
        "siswa_id" => "required",
    ];

    public function index(Kelas $kelas, KelasSub $kelasSub)
    {
        return view('admin.kelas.sub.siswa.index', compact('kelas', 'kelasSub'));
    }

    public function data(Kelas $kelas, KelasSub $kelasSub, Request $request)
    {
        $search = request('search.value');
        $data   = KelasSiswa::join('kelas_sub', 'kelas_sub.id', '=', 'kelas_siswa.kelas_sub_id')
            ->join('kelas', 'kelas.id', '=', 'kelas_sub.kelas_id')
            ->join('siswa', 'siswa.id', '=', 'kelas_siswa.siswa_id')
            ->where('kelas_siswa.kelas_sub_id', $kelasSub->id)
            ->select('kelas_siswa.*',
                'kelas.angka as kelas_angka',
                'kelas_sub.sub',
                'kelas.id as kelas_id',
                'siswa.nama_siswa',
                'siswa.foto',
                'siswa.nis',
                'siswa.nisn'
            );
        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('kelas_sub.sub', 'LIKE', "%$search%");
                    $query->orWhere('kelas.romawi', 'LIKE', "%$search%");
                    $query->orWhere('kelas.angka', 'LIKE', "%$search%");
                });
            })
            ->editColumn('nama_siswa', function ($row) {
                $row->foto = $row->foto ? asset('foto_guru/' . $row->foto) : asset('template/assets/img/user.jpg');
                return '
                    <div class="d-flex align-items-center">
                        <img src="' . $row->foto . '" alt="Foto Guru" class="rounded-circle me-2" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            ' . $row->nama_siswa . '<br>
                            <small>NIK: ' . ($row->nis ?? '-') . '</small><br>
                            <small>NIP: ' . ($row->nisn ?? '-') . '</small>
                        </div>
                    </div>
                ';
            })
            ->addColumn('action', function ($row) {
                $content = '<div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <form action="" onsubmit="deleteData(event)" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" name="id" value="' . $row->id . '">
                                <input type="hidden" name="nama" value="' . $row->nama_siswa . '">
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fa fa-trash-alt m-r-5"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>';
                return $content;
            })
            ->rawColumns(['action', 'nama_siswa'])
            ->toJson();
    }

    public function dataSiswa(Kelas $kelas, KelasSub $kelasSub, Request $request)
    {
        $search = request('search.value');
        $data   = Siswa::join('tahun_pelajaran', 'tahun_pelajaran.id', '=', 'siswa.tahun_pelajaran_id')
            ->join('kelas', 'kelas.id', '=', 'siswa.kelas_id')
            ->leftJoin('kelas_siswa', 'kelas_siswa.siswa_id', '=', 'siswa.id')
            ->where('status_daftar', 'diterima')
            ->whereNull('kelas_siswa.id')
            ->select('siswa.*', 'tahun_pelajaran.kode as tahun_pelajaran_kode', 'kelas.angka as kelas_angka');
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
                        <div>' . $row->nama_siswa . '<br>
                            <small>NIS: ' . ($row->nis ?? '-') . '</small><br>
                            <small>NISN: ' . ($row->nisn ?? '-') . '</small>
                        </div>
                    </div>
                ';
            })
            ->editColumn('status', function ($row) {
                return '<span class="badge bg-' . Helper::getColorStatus($row->status) . '">' . strtoupper($row->status) . '</span>';
            })
            ->addColumn('action', function ($row) {
                $content = '<div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="' . route("admin.siswa.edit", $row) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
                            <form action="" onsubmit="deleteData(event)" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" name="id" value="' . $row->id . '">
                                <input type="hidden" name="nama" value="' . $row->nama . '">
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fa fa-trash-alt m-r-5"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>';
                return $content;
            })
            ->rawColumns(['action', 'nama_siswa', 'status'])
            ->toJson();
    }

    public function add(Kelas $kelas, KelasSub $kelasSub)
    {
        return view('admin.kelas.sub.siswa.add', compact('kelas', 'kelasSub'));
    }

    public function store(Kelas $kelas, KelasSub $kelasSub, Request $request)
    {
        try {
            $request->validate($this->rules);

            $cek = KelasSiswa::where('kelas_sub_id', $kelasSub->id)
                ->whereIn('siswa_id', $request->siswa_id)->first();
            if ($cek) {
                throw new \Exception('Siswa sudah ada di kelas ini');
            }

            \DB::beginTransaction();
            foreach ($request->siswa_id as $key => $value) {
                $kelasSiswa               = new KelasSiswa();
                $kelasSiswa->kelas_sub_id = $kelasSub->id;
                $kelasSiswa->siswa_id     = $value;
                $kelasSiswa->save();
            }
            \DB::commit();
            return redirect()->route('admin.kelas.sub.siswa.index', ['kelas' => $kelas, 'kelasSub' => $kelasSub])->with('success')->with('success', 'Siswa Kelas berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.kelas.sub.siswa.add', ['kelas' => $kelas, 'kelasSub' => $kelasSub])
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            \DB::rollback();
            return redirect()->route('admin.kelas.sub.siswa.add', ['kelas' => $kelas, 'kelasSub' => $kelasSub])->with('error', $th->getMessage())->withInput();
        }
    }

    public function edit(Kelas $kelas, KelasSub $kelasSub, KelasSiswa $kelasSiswa)
    {
        $kelasSiswa = $kelasSiswa->load('guru');
        return view('admin.kelas.sub.siswa.edit', compact('kelas', 'kelasSub', 'kelasSiswa'));
    }

    public function update(Kelas $kelas, KelasSub $kelasSub, KelasSiswa $kelasSiswa, Request $request)
    {
        try {
            $request->validate($this->rules);

            $cek = KelasSiswa::where('kelas_sub_id', $kelasSub->id)->where('guru_id', $request->guru_id)->where('id', '!=', $kelasSiswa->id)->first();
            if ($cek) {
                throw new \Exception('Siswa Kelas sudah ada');
            }

            $kelasSiswa->kelas_sub_id = $kelasSub->id;
            $kelasSiswa->guru_id      = $request->guru_id;

            $kelasSiswa->save();

            return redirect()->route('admin.kelas.sub.siswa.index', ['kelas' => $kelas, 'kelasSub' => $kelasSub])->with('success', 'Siswa Kelas berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.kelas.sub.siswa.edit', ['kelas' => $kelas, 'kelasSub' => $kelasSub, 'kelasSiswa' => $kelasSiswa])
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.kelas.sub.siswa.edit', ['kelas' => $kelas, 'kelasSub' => $kelasSub, 'kelasSiswa' => $kelasSiswa])->with('error', $th->getMessage())->withInput();
        }
    }

    public function destroy(Kelas $kelas, KelasSub $kelasSub, KelasSiswa $kelasSiswa)
    {
        try {
            $kelasSiswa->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Siswa di kelas ini berhasil dihapus',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->getCode() == '23000') {
                return response()->json([
                    'status'  => false,
                    'message' => 'Siswa di kelas ini tidak dapat dihapus karena masih digunakan oleh user.',
                ]);
            }

            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan pada database: ' . $e->getMessage(),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function bulkDestroy(Kelas $kelas, KelasSub $kelasSub, Request $request)
    {
        try {
            KelasSiswa::whereIn('id', $request->id)->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Siswa di kelas ini berhasil dihapus',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->getCode() == '23000') {
                return response()->json([
                    'status'  => false,
                    'message' => 'Siswa di kelas ini tidak dapat dihapus karena masih digunakan oleh user.',
                ]);
            }

            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan pada database: ' . $e->getMessage(),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage(),
            ]);
        }
    }
}
