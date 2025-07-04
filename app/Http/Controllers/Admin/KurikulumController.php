<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use App\Models\KurikulumDetail;
use App\Models\MataPelajaran;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KurikulumController extends Controller
{
    private $rules = [
        "tahun_pelajaran_id" => "required",
        "nama"               => "required",
        "mata_pelajaran_id"  => "required",
    ];
    public function index()
    {
        return view('admin.kurikulum.index');
    }
    public function data(Request $request)
    {
        $search = request('search.value');
        $data   = Kurikulum::join('tahun_pelajaran', 'tahun_pelajaran.id', '=', 'kurikulum.tahun_pelajaran_id')
            ->select('kurikulum.*',
                'tahun_pelajaran.nama as tahun_pelajaran_nama',
                'tahun_pelajaran.semester as tahun_pelajaran_semester',
            );
        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search, $request) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('kurikulum.nama', 'LIKE', "%$search%");
                    $query->orWhere('tahun_pelajaran.nama', 'LIKE', "%$search%");
                    $query->orWhere('tahun_pelajaran.semester', 'LIKE', "%$search%");
                    $query->orWhere('tahun_pelajaran.kode', 'LIKE', "%$search%");
                });
            })
            ->addColumn('action', function ($row) {
                $content = '<div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="' . route("admin.kurikulum.edit", $row) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
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
            ->rawColumns(['action'])
            ->toJson();
    }
    public function add()
    {
        $tahunPelajaran = TahunPelajaran::all();
        $mataPelajaran  = MataPelajaran::all();
        return view('admin.kurikulum.add', compact('tahunPelajaran', 'mataPelajaran'));
    }
    public function store(Request $request)
    {
        try {
            $request->validate($this->rules);

            \DB::beginTransaction();

            $kurikulum                     = new Kurikulum();
            $kurikulum->tahun_pelajaran_id = $request->tahun_pelajaran_id;
            $kurikulum->nama               = $request->nama;
            $kurikulum->save();

            $kurikulumDetail = [];
            foreach ($request->mata_pelajaran_id as $key => $value) {
                $kurikulumDetail[] = [
                    'kurikulum_id'      => $kurikulum->id,
                    'mata_pelajaran_id' => $value,
                ];
            }

            KurikulumDetail::insert($kurikulumDetail);

            \DB::commit();
            return redirect()->route('admin.kurikulum.index')->with('success', 'Mata Pelajaran berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.kurikulum.add')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            \DB::rollBack();
            return redirect()->route('admin.kurikulum.add')->with('error', $th->getMessage())->withInput();
        }
    }
    public function edit(Kurikulum $kurikulum)
    {
        $tahunPelajaran         = TahunPelajaran::all();
        $mataPelajaran = MataPelajaran::all();
        return view('admin.kurikulum.edit', compact('kurikulum', 'tahunPelajaran', 'mataPelajaran'));
    }
    public function update(Request $request, Kurikulum $kurikulum)
    {
        try {
            $request->validate($this->rules);
            $kurikulum->tahun_pelajaran_id = $request->tahun;
            $kurikulum->mata_pelajaran_id  = $request->pelajaran;
            $kurikulum->save();
            return redirect()->route('admin.kurikulum.index')->with('success', 'Mata Pelajaran berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.kurikulum.edit')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.kurikulum.edit', ['kurikulum' => $kurikulum])->with('error', $th->getMessage())->withInput();
        }
    }
    public function destroy(Kurikulum $kurikulum)
    {
        try {
            $kurikulum->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Mata Pelajaran berhasil dihapus',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->getCode() == '23000') {
                return response()->json([
                    'status'  => false,
                    'message' => 'Mata Pelajaran tidak dapat dihapus karena masih digunakan oleh user.',
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
