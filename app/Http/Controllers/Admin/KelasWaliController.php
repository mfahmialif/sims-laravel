<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\KelasSub;
use App\Models\KelasWali;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KelasWaliController extends Controller
{
    private $rules = [
        "guru_id" => "required|string",
    ];

    public function index(Kelas $kelas, KelasSub $kelasSub)
    {
        return view('admin.kelas.sub.wali.index', compact('kelas', 'kelasSub'));
    }

    public function data(Kelas $kelas, KelasSub $kelasSub, Request $request)
    {
        $search = request('search.value');
        $data   = KelasWali::join('kelas_sub', 'kelas_sub.id', '=', 'kelas_wali.kelas_sub_id')
            ->join('kelas', 'kelas.id', '=', 'kelas_sub.kelas_id')
            ->join('guru', 'guru.id', '=', 'kelas_wali.guru_id')
            ->where('kelas_wali.kelas_sub_id', $kelasSub->id)
            ->select('kelas_wali.*',
                'kelas.angka as kelas_angka',
                'kelas_sub.sub',
                'kelas.id as kelas_id',
                'guru.nama',
                'guru.foto',
                'guru.nik',
                'guru.nip'
            );
        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('kelas_sub.sub', 'LIKE', "%$search%");
                    $query->orWhere('kelas.romawi', 'LIKE', "%$search%");
                    $query->orWhere('kelas.angka', 'LIKE', "%$search%");
                });
            })
            ->editColumn('nama', function ($row) {
                $row->foto = $row->foto ? asset('foto_guru/' . $row->foto) : asset('template/assets/img/user.jpg');
                return '
                    <div class="d-flex align-items-center">
                        <img src="' . $row->foto . '" alt="Foto Guru" class="rounded-circle me-2" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            ' . $row->nama . '<br>
                            <small>NIK: ' . ($row->nik ?? '-') . '</small><br>
                            <small>NIP: ' . ($row->nip ?? '-') . '</small>
                        </div>
                    </div>
                ';
            })
            ->addColumn('action', function ($row) {
                $content = '<div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="' . route("admin.kelas.sub.wali.edit", [
                    'kelas'     => $row->kelas_id,
                    'kelasSub'  => $row->kelas_sub_id,
                    'kelasWali' => $row->id,
                ]) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
                            <form action="" onsubmit="deleteData(event)" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" name="id" value="' . $row->id . '">
                                <input type="hidden" name="nama" value="' . $row->sub . '">
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

    public function add(Kelas $kelas, KelasSub $kelasSub)
    {
        return view('admin.kelas.sub.wali.add', compact('kelas', 'kelasSub'));
    }

    public function store(Kelas $kelas, KelasSub $kelasSub, Request $request)
    {
        try {
            $request->validate($this->rules);

            $cek = KelasWali::where('kelas_sub_id', $kelasSub->id)->where('guru_id', $request->guru_id)->first();
            if ($cek) {
                throw new \Exception('Wali Kelas sudah ada');
            }

            $kelasWali               = new KelasWali();
            $kelasWali->kelas_sub_id = $kelasSub->id;
            $kelasWali->guru_id      = $request->guru_id;
            $kelasWali->save();

            return redirect()->route('admin.kelas.sub.wali.index', ['kelas' => $kelas, 'kelasSub' => $kelasSub])->with('success')->with('success', 'Wali Kelas berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.kelas.sub.wali.add', ['kelas' => $kelas, 'kelasSub' => $kelasSub])
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.kelas.sub.wali.add', ['kelas' => $kelas, 'kelasSub' => $kelasSub])->with('error', $th->getMessage())->withInput();
        }
    }

    public function edit(Kelas $kelas, KelasSub $kelasSub, KelasWali $kelasWali)
    {
        $kelasWali = $kelasWali->load('guru');
        return view('admin.kelas.sub.wali.edit', compact('kelas', 'kelasSub', 'kelasWali'));
    }

    public function update(Kelas $kelas, KelasSub $kelasSub, KelasWali $kelasWali, Request $request)
    {
        try {
            $request->validate($this->rules);

            $cek = KelasWali::where('kelas_sub_id', $kelasSub->id)->where('guru_id', $request->guru_id)->where('id', '!=', $kelasWali->id)->first();
            if ($cek) {
                throw new \Exception('Wali Kelas sudah ada');
            }

            $kelasWali->kelas_sub_id = $kelasSub->id;
            $kelasWali->guru_id      = $request->guru_id;

            $kelasWali->save();

            return redirect()->route('admin.kelas.sub.wali.index', ['kelas' => $kelas, 'kelasSub' => $kelasSub])->with('success', 'Wali Kelas berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.kelas.sub.wali.edit', ['kelas' => $kelas, 'kelasSub' => $kelasSub, 'kelasWali' => $kelasWali])
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.kelas.sub.wali.edit', ['kelas' => $kelas, 'kelasSub' => $kelasSub, 'kelasWali' => $kelasWali])->with('error', $th->getMessage())->withInput();
        }
    }

    public function destroy(Kelas $kelas, KelasSub $kelasSub, KelasWali $kelasWali)
    {
        try {
            $kelasWali->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Wali Kelas berhasil dihapus',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->getCode() == '23000') {
                return response()->json([
                    'status'  => false,
                    'message' => 'Wali Kelas tidak dapat dihapus karena masih digunakan oleh user.',
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
