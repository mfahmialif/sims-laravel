<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TahunPelajaranController extends Controller
{
     private $rules = [
        "nama" => "required|string",
        "kode" => "required|string",
        "status"=>"required|string",
        "semester" => "required|string"
    ];
    function index()
    {
        return view('admin.tahun-pelajaran.index');
    }
    function data(Request $request)
    {
        $search = request('search.value');
        $data   = TahunPelajaran::select('*');
        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('kode', 'LIKE', "%$search%");
                    $query->orWhere('nama', 'LIKE', "%$search%");
                    $query->orWhere('semester', 'LIKE', "%$search%");
                    $query->orWhere('status', 'LIKE', "%$search%");
                });
            })->addColumn('action', function ($row) {
                $content = '<div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="' . route("admin.tahun-pelajaran.edit", $row) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
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
            ->rawColumns(['action'])
            ->toJson();
    }
    function add()
    {
        return view('admin.tahun-pelajaran.add');
    }
    function store(Request $request)
    {
        try {
            $request->validate($this->rules);
            $tahunPelajaran = new TahunPelajaran();
            $tahunPelajaran->nama = $request->nama;
            $tahunPelajaran->kode = $request->kode;
            $tahunPelajaran->status = $request->status;
            $tahunPelajaran->semester = $request->semester;
            $tahunPelajaran->save();
            return redirect()->route('admin.tahun-pelajaran.index')->with('success', 'Mata Pelajaran berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.tahun-pelajaran.add')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.tahun-pelajaran.add')->with('error', $th->getMessage())->withInput();
        }
    }
    function edit(TahunPelajaran $tahunPelajaran)
    {
        return view('admin.tahun-pelajaran.edit',compact('tahunPelajaran'));
    }
    function update(Request $request, TahunPelajaran $tahunPelajaran)
    {
        try {
            $request->validate($this->rules);
                $tahunPelajaran->nama   = $request->nama;
                $tahunPelajaran->kode   = $request->kode;
                $tahunPelajaran->status = $request->status;
                $tahunPelajaran->semester = $request->semester;
                $tahunPelajaran->save();
            return redirect()->route('admin.tahun-pelajaran.index')->with('success', 'Mata Pelajaran berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.tahun-pelajaran.edit')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
           return redirect()->route('admin.tahun-pelajaran.edit', ['tahunPelajaran' => $tahunPelajaran])->with('error', $th->getMessage())->withInput();
        }
    }
    function destroy(TahunPelajaran $tahunPelajaran){
        try {
            $tahunPelajaran->delete();
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
