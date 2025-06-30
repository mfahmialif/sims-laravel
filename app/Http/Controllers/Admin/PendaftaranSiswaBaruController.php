<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Helper;
use App\Models\Role;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class PendaftaranSiswaBaruController extends Controller
{
    private $rules = [
        'name'                  => 'required|string|max:255',
        'jenis_kelamin'         => 'required|string|max:255',
        'username'              => 'required|unique:users,username',
        'email'                 => 'nullable|email|unique:users,email',
        'role_id'               => 'required|exists:role,id',
        'password'              => 'required|string|min:6|confirmed',
        'password_confirmation' => 'required|string|min:6',
        'avatar'                => 'nullable|mimes:jpeg,png,jpg,gif,webp,ico|max:' . (1024 * 5),
    ];

    public function index()
    {
        return view('admin.pendaftaran-siswa-baru.index');
    }

    public function data(Request $request)
    {
        $search = request('search.value');
        $data   = Siswa::select('*');
        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('nama_siswa', 'LIKE', "%$search%");
                    $query->orWhere('jenis_kelammin', 'LIKE', "%$search%");
                });
            })
            ->addColumn('action', function ($row) {
                $content = '<div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="' . route("admin.pendaftaran-siswa-baru.edit", $row) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
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
        $jenisKelamin = Helper::getEnumValues('users', 'jenis_kelamin');
        $role         = Role::all();
        return view('admin.pendaftaran-siswa-baru.add', compact('role', 'jenisKelamin'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate($this->rules);

            $siswa                = new Siswa();
            $siswa->username      = $request->username;
            $siswa->name          = $request->name;
            $siswa->jenis_kelamin = $request->jenis_kelamin;
            $siswa->email         = $request->email;
            $siswa->role_id       = $request->role_id;
            $siswa->password      = Hash::make($request->password);

            if ($request->hasFile('avatar')) {
                $siswa->avatar = Helper::uploadFile($request->file('avatar'), $request->username, 'avatar');
            }

            $siswa->save();
            return redirect()->route('admin.pendaftaran-siswa-baru.index')->with('success', 'Siswa berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.pendaftaran-siswa-baru.add')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.pendaftaran-siswa-baru.add')->with('error', $th->getMessage())->withInput();
        }

    }

    public function edit(Siswa $siswa)
    {
        $jenisKelamin = Helper::getEnumValues('users', 'jenis_kelamin');
        $role         = Role::all();
        return view('admin.pendaftaran-siswa-baru.edit', compact('siswa', 'role', 'jenisKelamin'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        try {
            $this->rules = array_merge($this->rules, [
                'username'              => 'required|unique:users,username,' . $siswa->id,
                'email'                 => 'nullable|unique:users,email,' . $siswa->id,
                'password'              => 'nullable|string|min:6|confirmed',
                'password_confirmation' => 'required_with:password',
            ]);
            $request->validate($this->rules);

            $siswa->username      = $request->username;
            $siswa->name          = $request->name;
            $siswa->jenis_kelamin = $request->jenis_kelamin;
            $siswa->email         = $request->email;
            $siswa->role_id       = $request->role_id;

            if ($request->password) {
                $siswa->password = Hash::make($request->password);
            }

            if ($request->hasFile('avatar')) {
                if ($siswa->avatar) {
                    Helper::deleteFile($siswa->avatar);
                }
                $siswa->avatar = Helper::uploadFile($request->file('avatar'), $request->username, 'avatar');
            }

            $siswa->save();
            return redirect()->route('admin.pendaftaran-siswa-baru.index')->with('success', 'Siswa berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.pendaftaran-siswa-baru.edit')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.pendaftaran-siswa-baru.edit', ['siswa' => $siswa])->with('error', $th->getMessage())->withInput();
        }
    }

    public function destroy(Siswa $siswa)
    {
        try {
            if ($siswa->avatar) {
                Helper::deleteFile($siswa->avatar, 'avatar');
            }
            $siswa->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Siswa berhasil dihapus',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage(),
            ]);
        }
    }
}
