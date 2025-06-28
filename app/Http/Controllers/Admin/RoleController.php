<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    private $rules = [
        'nama' => 'required|unique:role,nama|string|max:50',
    ];

    public function index()
    {
        return view('admin.role.index');
    }

    public function data(Request $request)
    {
        $search = request('search.value');
        $data   = Role::select('*');
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
                            <a class="dropdown-item" href="' . route("admin.role.edit", $row) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
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
        return view('admin.role.add');
    }

    public function store(Request $request)
    {
        try {
            $request->validate($this->rules);

            $role       = new Role();
            $role->nama = $request->nama;

            $role->save();
            return redirect()->route('admin.role.index')->with('success', 'Role berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.role.add')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.role.add')->with('error', $th->getMessage())->withInput();
        }

    }

    public function edit(Role $role)
    {
        return view('admin.role.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        try {
            $this->rules = array_merge($this->rules, [
                'nama' => 'required|unique:role,nama,' . $role->id,
            ]);
            $request->validate($this->rules);

            $role->nama = $request->nama;

            $role->save();
            return redirect()->route('admin.role.index')->with('success', 'Role berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.role.edit')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.role.edit', ['role' => $role])->with('error', $th->getMessage())->withInput();
        }
    }

    public function destroy(Role $role)
    {
        try {
            $role->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Role berhasil dihapus',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return response()->json([
                    'status'  => false,
                    'message' => 'Role tidak dapat dihapus karena masih digunakan oleh user.',
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
