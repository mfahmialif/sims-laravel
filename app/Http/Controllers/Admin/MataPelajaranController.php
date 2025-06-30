<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    private $rules = [
        "romawi" => "required|string",
        "angka" => "required|string",
        "keterangan" => "required|string"
    ];
    function index()
    {
        return view('admin.kelas.index');
    }
    function data(Request $request)
    {
        $search = request('search.value');
        $data   = Kelas::select('*');
        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('romawi', 'LIKE', "%$search%");
                    $query->orWhere('angka', 'LIKE', "%$search%");
                    $query->orWhere('keterangan', 'LIKE', "%$search%");
                });
            })
            ->addColumn('action', function ($row) {
                $content = '<div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="' . route("admin.mata-pelajaran.edit", $row) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
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
            ->rawColumns(['action', 'name'])
            ->toJson();
    }
    function add()
    {
        return view('admin.mata-pelajaran.add');
    }
    function store(Request $request)
    {
        try {
            $request->validate($this->rules);
            $mataPelajaran = new MataPelajaran();
            $mataPelajaran->nama = $request->nama;
            $mataPelajaran->kode = $request->kode;
            $mataPelajaran->status = $request->status;
            $mataPelajaran->kelas_id = $request->kelas_id;
            $mataPelajaran->save();
            return redirect()->route('admin.mata-pelajaran.index')->with('success', 'Mata Pelajaran berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.mata-pelajaran.add')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.mata-pelajaran.add')->with('error', $th->getMessage())->withInput();
        }
    }
    function edit(MataPelajaran $mataPelajaran)
    {
        return view('admin.mata-pelajaran.edit',compact('mataPelajaran'));
    }
    function update(Request $request, MataPelajaran $mataPelajaran)
    {
        try {

            $rules = $this->rules;
            $rules["id"] = "required";
            $request->validate($this->rules);

                $mataPelajaran->romawi = $request->romawi;
                $mataPelajaran->angka = $request->angka;
                $mataPelajaran->keterangan = $request->keterangan;
                $mataPelajaran->save();
            return redirect()->route('admin.mata-pelajaran.index')->with('success', 'Mata Pelajaran berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.mata-pelajaran.edit')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
           return redirect()->route('admin.mata-pelajaran.edit', ['mataPelajaran' => $mataPelajaran])->with('error', $th->getMessage())->withInput();
        }
    }
    function destroy(MataPelajaran $mataPelajaran){
        try {
            $mataPelajaran->delete();
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
