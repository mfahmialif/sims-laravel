<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use App\Models\MataPelajaran;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KurikulumController extends Controller
{
    private $rules = [
        "tahun" => "required|string",
        "pelajaran" => "required|string",
    ];
    function index()
    {
        return view('admin.kurikulum.index');
    }
    function data(Request $request)
    {
        $search = request('search.value');
        $data   = Kurikulum::with('mataPelajaran', 'tahunPelajaran')->select('*');
        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search, $request) {
                $query->where(function ($query) use ($search) {
                    // $query->orWhere('mataPelajaran.kode', 'LIKE', "%$search%");
                    // $query->orWhere('tahunAjaran.kode', 'LIKE', "%$search%");
                    // $query->orWhere('mataPelajaran.kelas.angka', 'LIKE', "%$search%");
                    $query->whereHas('mataPelajaran', function ($q) use ($search) {
                        $q->where('kode', 'LIKE', "%$search%")
                            ->orwhereHas('kelas', function ($k) use ($search) {
                                $k->where('angka', 'LIKE', "%$search%");
                            });
                        
                    })->orwhereHas('tahunpelajaran',function($q) use ($search) {
                        $q->where('kode','LIKE',"%$search%");
                    });
                });
            })
            ->addColumn('tahun', function ($row) {
                return $row->tahunPelajaran->kode;
            })
            ->addColumn('mata_pelajaran', function ($row) {
                return $row->mataPelajaran->kode;
            })
            ->addColumn('kelas', function ($row) {
                return $row->mataPelajaran->kelas->angka;
            })
            ->addColumn('action', function ($row) {
                $content = '<div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="' . route("admin.kurikulum.edit", $row) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
                            <form action="" onsubmit="deleteData(event)" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" name="id" value="' . $row->id . '">
                                <input type="hidden" name="name" value="' . $row->name . '">
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fa fa-trash-alt m-r-5"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>';
                return $content;
            })
            ->rawColumns(['action', 'tahun', 'mata_pelajaran', 'kelas'])
            ->toJson();
    }
    function add()
    {
        $tahun = TahunPelajaran::all();
        $mataPelajaran = MataPelajaran::all();
        return view('admin.kurikulum.add', compact('tahun', 'mataPelajaran'));
    }
    function store(Request $request)
    {
        try {
            $request->validate($this->rules);
            $kurikulum = new Kurikulum();
            $kurikulum->tahun_pelajaran_id = $request->tahun;
            $kurikulum->mata_pelajaran_id = $request->pelajaran;
            $kurikulum->save();
            return redirect()->route('admin.kurikulum.index')->with('success', 'Mata Pelajaran berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.kurikulum.add')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.kurikulum.add')->with('error', $th->getMessage())->withInput();
        }
    }
    function edit(Kurikulum $kurikulum)
    {
        $tahun = TahunPelajaran::all();
        $mataPelajaran = MataPelajaran::all();
        return view('admin.kurikulum.edit', compact('kurikulum','tahun','mataPelajaran'));
    }
    function update(Request $request, Kurikulum $kurikulum)
    {
        try {
            $request->validate($this->rules);
            $kurikulum->tahun_pelajaran_id   = $request->tahun;
            $kurikulum->mata_pelajaran_id   = $request->pelajaran;
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
    function destroy(Kurikulum $kurikulum)
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
