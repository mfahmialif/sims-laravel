<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Kurikulum;
use App\Models\KurikulumDetail;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class JadwalController extends Controller
{
    private $rules = [
        // 'nama' => 'required|unique:jadwal,nama|string|max:50',
    ];

    public function index()
    {
        $tahunPelajaran = TahunPelajaran::orderBy('kode', 'desc')->get();
        return view('admin.jadwal.index', compact('tahunPelajaran'));
    }

    public function data(Request $request)
    {
        $kurikulum = Kurikulum::with([
            'detail' => function ($q) {
                $q->join('mata_pelajaran', 'kurikulum_detail.mata_pelajaran_id', '=', 'mata_pelajaran.id')
                    ->join('kelas', 'mata_pelajaran.kelas_id', '=', 'kelas.id')
                    ->orderBy('kelas.angka');
            },
            'detail.mataPelajaran.kelas',
        ])->get();

        $tahunPelajaran = TahunPelajaran::find($request->tahun_pelajaran_id);
        return view('admin.jadwal.kurikulum', compact('kurikulum', 'tahunPelajaran'));
    }

    public function detail(KurikulumDetail $kurikulumDetail, TahunPelajaran $tahunPelajaran)
    {

    }

    public function dataDetail(Request $request)
    {
        $search = request('search.value');
        $data   = Jadwal::select('*');
        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('nama', 'LIKE', "%$search%");
                });
            })
            ->addColumn('action', function ($row) {
                $content = '<div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="' . route("admin.jadwal.edit", $row) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
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
            ->rawColumns(['action', 'name'])
            ->toJson();
    }

    public function add()
    {
        return view('admin.jadwal.add');
    }

    public function store(Request $request)
    {
        try {
            $request->validate($this->rules);

            $jadwal       = new Jadwal();
            $jadwal->nama = $request->nama;

            $jadwal->save();
            return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.jadwal.add')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.jadwal.add')->with('error', $th->getMessage())->withInput();
        }

    }

    public function edit(Jadwal $jadwal)
    {
        return view('admin.jadwal.edit', compact('jadwal'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        try {
            $this->rules = array_merge($this->rules, [
                'nama' => 'required|unique:jadwal,nama,' . $jadwal->id,
            ]);
            $request->validate($this->rules);

            $jadwal->nama = $request->nama;

            $jadwal->save();
            return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.jadwal.edit')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.jadwal.edit', ['jadwal' => $jadwal])->with('error', $th->getMessage())->withInput();
        }
    }

    public function destroy(Jadwal $jadwal)
    {
        try {
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
