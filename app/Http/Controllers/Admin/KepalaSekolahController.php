<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\KepalaSekolah;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KepalaSekolahController extends Controller
{
    private $rules = [
        'guru_id'         => 'required|exists:guru,id|unique:kepala_sekolah,guru_id',
        'mulai_menjabat'  => 'nullable|date',
        'selesa_menjabat' => 'nullable|date',
    ];

    public function index()
    {
        return view('admin.kepala-sekolah.index');
    }

    public function autocomplete($query)
    {
        return Guru::where('nama', 'LIKE', "%$query%")
            ->select('*')
            ->limit(100)
            ->get()
            ->map(function ($item) {
                $nip = $item->nip ?? "-";
                return [
                    'label' => $item->nama . "(NIP: $nip)",
                    'value' => $item->id,
                    'data'  => $item,
                ];
            });
    }
    public function data(Request $request)
    {
        $search = request('search.value');
        $data   = KepalaSekolah::join('guru', 'guru.id', '=', 'kepala_sekolah.guru_id')
            ->select('kepala_sekolah.*', 'guru.nama');
        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('guru.nama', 'LIKE', "%$search%");
                });
            })
            ->addColumn('action', function ($row) {
                $content = '<div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="' . route("admin.kepala-sekolah.edit", $row) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
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
        return view('admin.kepala-sekolah.add');
    }

    public function store(Request $request)
    {
        try {
            $request->validate($this->rules);

            $kepalaSekolah = KepalaSekolah::where('guru_id', $request->guru_id)->first();

            if ($kepalaSekolah) {
                throw new \Exeption('Kepala Sekolah dengan guru ini sudah ada');
            }
            $kepalaSekolah                   = new KepalaSekolah();
            $kepalaSekolah->guru_id          = $request->guru_id;
            $kepalaSekolah->mulai_menjabat   = $request->mulai_menjabat;
            $kepalaSekolah->selesai_menjabat = $request->selesai_menjabat;

            $kepalaSekolah->save();
            return redirect()->route('admin.kepala-sekolah.index')->with('success', 'Kepala Sekolah berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.kepala-sekolah.add')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.kepala-sekolah.add')->with('error', $th->getMessage())->withInput();
        }

    }

    public function edit(KepalaSekolah $kepalaSekolah)
    {
        $kepalaSekolah = $kepalaSekolah->load('guru');
        return view('admin.kepala-sekolah.edit', compact('kepalaSekolah'));
    }

    public function update(Request $request, KepalaSekolah $kepalaSekolah)
    {
        try {
            $this->rules = array_merge($this->rules, [
                'guru_id' => 'required|unique:kepala_sekolah,guru_id,' . $kepalaSekolah->id,
            ]);
            $request->validate($this->rules);

            $kepalaSekolah->guru_id          = $request->guru_id;
            $kepalaSekolah->mulai_menjabat   = $request->mulai_menjabat;
            $kepalaSekolah->selesai_menjabat = $request->selesai_menjabat;

            $kepalaSekolah->save();
            return redirect()->route('admin.kepala-sekolah.index')->with('success', 'Kepala Sekolah berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.kepala-sekolah.edit', ['kepalaSekolah' => $kepalaSekolah])
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.kepala-sekolah.edit', ['kepalaSekolah' => $kepalaSekolah])->with('error', $th->getMessage())->withInput();
        }
    }

    public function destroy(KepalaSekolah $kepalaSekolah)
    {
        try {
            $kepalaSekolah->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Kepala Sekolah berhasil dihapus',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return response()->json([
                    'status'  => false,
                    'message' => 'Kepala Sekolah tidak dapat dihapus karena masih digunakan oleh user.',
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
