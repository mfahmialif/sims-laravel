<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\KurikulumDetail;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class JadwalDetailController extends Controller
{
    protected $kurikulumDetail;
    protected $tahunPelajaran;

    private $rules = [
        // 'nama' => 'required|unique:jadwal,nama|string|max:50',
    ];

    public function __construct(Request $request)
    {
        $this->kurikulumDetail = KurikulumDetail::findOrFail(request()->route('kurikulumDetail'));
        $this->tahunPelajaran  = TahunPelajaran::findOrFail(request()->route('tahunPelajaran'));
    }

    public function index()
    {
        $kurikulumDetail = $this->kurikulumDetail;
        $tahunPelajaran  = $this->tahunPelajaran;
        return view('admin.jadwal.detail.index', compact('kurikulumDetail', 'tahunPelajaran'));
    }

    public function data(Request $request)
    {
        $kurikulumDetail = $this->kurikulumDetail;
        $tahunPelajaran  = $this->tahunPelajaran;

        $search = request('search.value');
        $data   = Jadwal::join('guru', 'guru.id', '=', 'jadwal.guru_id')
            ->join('kelas_sub', 'kelas_sub.id', '=', 'jadwal.kelas_sub_id')
            ->join('kelas', 'kelas.id', '=', 'kelas_sub.kelas_id')
            ->select('jadwal.*', 'guru.nama', 'guru.foto', 'guru.nip', 'guru.nik', 'kelas_sub.sub', 'kelas.angka', 'kelas.romawi');
        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('hari', 'LIKE', "%$search%");
                    $query->orWhere('jam_mulai', 'LIKE', "%$search%");
                    $query->orWhere('jam_selesai', 'LIKE', "%$search%");
                });
            })
            ->editColumn('sub', function ($row) {
                return $row->angka . ' ' . $row->sub;
            })
            ->editColumn('nama', function ($row) {
                $row->foto = $row->foto ? asset('foto_guru/' . $row->foto) : asset('template/assets/img/user.jpg');
                return '
                    <div class="d-flex align-items-center">
                        <img src="' . $row->foto . '" alt="Foto Guru" class="rounded-circle me-2" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>' . $row->nama . '<br>
                            <small>NIK: ' . ($row->nik ?? '-') . '</small><br>
                            <small>NIP: ' . ($row->nip ?? '-') . '</small>
                        </div>
                    </div>
                ';
            })
            ->addColumn('action', function ($row) use ($kurikulumDetail, $tahunPelajaran) {
                $content = '<div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="' . route("admin.jadwal.detail.edit", ['kurikulumDetail' => $kurikulumDetail, 'tahunPelajaran' => $tahunPelajaran, 'jadwal' => $row->id]) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
                            <form action="" onsubmit="deleteData(event)" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" name="id" value="' . $row->id . '">
                                <input type="hidden" name="nama" value="' . $row->hari . '">
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fa fa-trash-alt m-r-5"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>';
                return $content;
            })
            ->rawColumns(['action', 'nama'])
            ->toJson();
    }

    public function add()
    {
        $kurikulumDetail = $this->kurikulumDetail;
        $tahunPelajaran  = $this->tahunPelajaran;
        return view('admin.jadwal.detail.add', compact('kurikulumDetail', 'tahunPelajaran'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate($this->rules);

            $kurikulumDetail = $this->kurikulumDetail;
            $tahunPelajaran  = $this->tahunPelajaran;

            $request->merge([
                'tahun_pelajaran_id'  => $tahunPelajaran->id,
                'kurikulum_detail_id' => $kurikulumDetail->id,
            ]);

            // Cek bentrok guru
            $bentrokGuru = Jadwal::where('guru_id', $request->guru_id)
                ->where('hari', $request->hari)
                ->when($request->jadwal_id, function ($q) use ($request) {
                    $q->where('id', '!=', $request->jadwal_id);
                })
                ->where(function ($query) use ($request) {
                    $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhere(function ($q) use ($request) {
                            $q->where('jam_mulai', '<=', $request->jam_mulai)
                                ->where('jam_selesai', '>=', $request->jam_selesai);
                        });
                })
                ->exists();

            if ($bentrokGuru) {
                abort(403, 'Jadwal guru bentrok, guru sudah dijadwalkan di waktu yang sama. Harap memilih guru yang lain.');
            }

            // Cek bentrok mata pelajaran
            $bentrokMapel = Jadwal::where('kelas_sub_id', $request->kelas_sub_id)
                ->where('kurikulum_detail_id', $request->kurikulum_detail_id) // pastikan bukan mapel yg sama
                ->when($request->jadwal_id, function ($q) use ($request) {
                    $q->where('id', '!=', $request->jadwal_id);
                })
                ->exists();

            if ($bentrokMapel) {
                abort(403, 'Sudah ada mata pelajaran ini di kelas ini. Harap cek jadwal kelas.');
            }

            $jadwal                      = new Jadwal();
            $jadwal->tahun_pelajaran_id  = $request->tahun_pelajaran_id;
            $jadwal->kurikulum_detail_id = $request->kurikulum_detail_id;
            $jadwal->kelas_sub_id        = $request->kelas_sub_id;
            $jadwal->guru_id             = $request->guru_id;
            $jadwal->hari                = $request->hari;
            $jadwal->jam_mulai           = $request->jam_mulai;
            $jadwal->jam_selesai         = $request->jam_selesai;

            $jadwal->save();
            return redirect()->route('admin.jadwal.detail.index', [
                'kurikulumDetail' => $kurikulumDetail,
                'tahunPelajaran'  => $tahunPelajaran,
            ])->with('success', 'Jadwal berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.jadwal.detail.add', [
                'kurikulumDetail' => $kurikulumDetail,
                'tahunPelajaran'  => $tahunPelajaran,
            ])
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.jadwal.detail.add', [
                'kurikulumDetail' => $kurikulumDetail,
                'tahunPelajaran'  => $tahunPelajaran,
            ])->with('error', $th->getMessage())->withInput();
        }

    }

    public function edit()
    {
        $kurikulumDetail = $this->kurikulumDetail;
        $tahunPelajaran  = $this->tahunPelajaran;
        $jadwal          = Jadwal::findOrFail(request()->route('jadwal'))->load('guru');

        return view('admin.jadwal.detail.edit', compact('jadwal', 'kurikulumDetail', 'tahunPelajaran'));
    }

    public function update(Request $request)
    {
        try {
            $jadwal = Jadwal::findOrFail(request()->route('jadwal'))->load('guru');
            $request->validate($this->rules);

            $kurikulumDetail = $this->kurikulumDetail;
            $tahunPelajaran  = $this->tahunPelajaran;

            $request->merge([
                'tahun_pelajaran_id'  => $tahunPelajaran->id,
                'kurikulum_detail_id' => $kurikulumDetail->id,
                'jadwal_id' => $jadwal->id,
            ]);

            // Cek bentrok guru
            $bentrokGuru = Jadwal::where('guru_id', $request->guru_id)
                ->where('hari', $request->hari)
                ->when($request->jadwal_id, function ($q) use ($request) {
                    $q->where('id', '!=', $request->jadwal_id);
                })
                ->where(function ($query) use ($request) {
                    $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhere(function ($q) use ($request) {
                            $q->where('jam_mulai', '<=', $request->jam_mulai)
                                ->where('jam_selesai', '>=', $request->jam_selesai);
                        });
                })
                ->exists();

            if ($bentrokGuru) {
                abort(403, 'Jadwal guru bentrok, guru sudah dijadwalkan di waktu yang sama. Harap memilih guru yang lain.');
            }

            // Cek bentrok mata pelajaran
            $bentrokMapel = Jadwal::where('kelas_sub_id', $request->kelas_sub_id)
                ->where('kurikulum_detail_id', $request->kurikulum_detail_id) // pastikan bukan mapel yg sama
                ->when($request->jadwal_id, function ($q) use ($request) {
                    $q->where('id', '!=', $request->jadwal_id);
                })
                ->exists();

            if ($bentrokMapel) {
                abort(403, 'Sudah ada mata pelajaran ini di kelas ini. Harap cek jadwal kelas.');
            }

            $jadwal->tahun_pelajaran_id  = $request->tahun_pelajaran_id;
            $jadwal->kurikulum_detail_id = $request->kurikulum_detail_id;
            $jadwal->kelas_sub_id        = $request->kelas_sub_id;
            $jadwal->guru_id             = $request->guru_id;
            $jadwal->hari                = $request->hari;
            $jadwal->jam_mulai           = $request->jam_mulai;
            $jadwal->jam_selesai         = $request->jam_selesai;

            $jadwal->save();
            return redirect()->route('admin.jadwal.detail.index', [
                'kurikulumDetail' => $kurikulumDetail,
                'tahunPelajaran'  => $tahunPelajaran,
            ])->with('success', 'Jadwal berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.jadwal.detail.edit', [
                'kurikulumDetail' => $kurikulumDetail,
                'tahunPelajaran'  => $tahunPelajaran,
                'jadwal'          => $jadwal,
            ])
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.jadwal.detail.edit', [
                'kurikulumDetail' => $kurikulumDetail,
                'tahunPelajaran'  => $tahunPelajaran,
                'jadwal'          => $jadwal,
            ])->with('error', $th->getMessage())->withInput();
        }

    }

    public function destroy()
    {
        try {
            $jadwal          = Jadwal::findOrFail(request()->route('jadwal'));
            $kurikulumDetail = $this->kurikulumDetail;
            $tahunPelajaran  = $this->tahunPelajaran;
            $jadwal->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Jadwal berhasil dihapus',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return response()->json([
                    'status'  => false,
                    'message' => 'Jadwal tidak dapat dihapus karena masih digunakan oleh user.',
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
