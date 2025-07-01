<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MataPelajaranController extends Controller
{
    private $rules = [
        "nama" => "required|string",
        "kode" => "required|string",
        "status"=>"required|string",
        "kelas" => "required|string"
    ];
    function index()
    {
        return view('admin.mata-pelajaran.index');
    }
    function data(Request $request)
    {
        $search = request('search.value');
        $data   = MataPelajaran::with('kelas')->select('*');
        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search, $request) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('nama', 'LIKE', "%$search%");
                    $query->orWhere('kode', 'LIKE', "%$search%");
                    $query->orWhere('status', 'LIKE', "%$search%");
                });
            })
            ->addColumn('kelas',function($row){
                return $row->kelas->angka;
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
            ->rawColumns(['action', 'name','kelas'])
            ->toJson();
    }
    function add()
    {
        $kelas = Kelas::all();
        return view('admin.mata-pelajaran.add',compact('kelas'));
    }
    function store(Request $request)
    {
        try {
            $request->validate($this->rules);
            $mataPelajaran = new MataPelajaran();
            $mataPelajaran->nama = $request->nama;
            $mataPelajaran->kode = $request->kode;
            $mataPelajaran->status = $request->status;
            $mataPelajaran->kelas_id = $request->kelas;
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
        $kelas = Kelas::all();
        return view('admin.mata-pelajaran.edit',compact('mataPelajaran','kelas'));
    }
    function update(Request $request, MataPelajaran $mataPelajaran)
    {
        try {
            $request->validate($this->rules);
                $mataPelajaran->nama   = $request->nama;
                $mataPelajaran->kode   = $request->kode;
                $mataPelajaran->status = $request->status;
                $mataPelajaran->kelas  = $request->kelas;
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
