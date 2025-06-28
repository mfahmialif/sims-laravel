<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Helper;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UserController extends Controller
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
        return view('admin.user.index');
    }

    public function data(Request $request)
    {
        $search = request('search.value');
        $data   = User::select('*');
        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('username', 'LIKE', "%$search%");
                    $query->orWhere('name', 'LIKE', "%$search%");
                    $query->orWhere('email', 'LIKE', "%$search%");
                });
            })
            ->addColumn('action', function ($row) {
                $content = '<div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="' . route("admin.user.edit", $row) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
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

    public function add()
    {
        $jenisKelamin = Helper::getEnumValues('users', 'jenis_kelamin');
        $role         = Role::all();
        return view('admin.user.add', compact('role', 'jenisKelamin'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate($this->rules);

            $user                = new User();
            $user->username      = $request->username;
            $user->name          = $request->name;
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->email         = $request->email;
            $user->role_id       = $request->role_id;
            $user->password      = Hash::make($request->password);

            if ($request->hasFile('avatar')) {
                $user->avatar = Helper::uploadFile($request->file('avatar'), $request->username, 'avatar');
            }

            $user->save();
            return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.user.add')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.user.add')->with('error', $th->getMessage())->withInput();
        }

    }

    public function edit(User $user)
    {
        $jenisKelamin = Helper::getEnumValues('users', 'jenis_kelamin');
        $role         = Role::all();
        return view('admin.user.edit', compact('user', 'role', 'jenisKelamin'));
    }

    public function update(Request $request, User $user)
    {
        try {
            $this->rules = array_merge($this->rules, [
                'username'              => 'required|unique:users,username,' . $user->id,
                'email'                 => 'nullable|unique:users,email,' . $user->id,
                'password'              => 'nullable|string|min:6|confirmed',
                'password_confirmation' => 'required_with:password',
            ]);
            $request->validate($this->rules);

            $user->username      = $request->username;
            $user->name          = $request->name;
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->email         = $request->email;
            $user->role_id       = $request->role_id;

            if ($request->password) {
                $user->password = Hash::make($request->password);
            }

            if ($request->hasFile('avatar')) {
                if ($user->avatar) {
                    Helper::deleteFile($user->avatar);
                }
                $user->avatar = Helper::uploadFile($request->file('avatar'), $request->username, 'avatar');
            }

            $user->save();
            return redirect()->route('admin.user.index')->with('success', 'User berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.user.edit')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.user.edit', ['user' => $user])->with('error', $th->getMessage())->withInput();
        }
    }

    public function destroy(User $user)
    {
        try {
            if ($user->avatar) {
                Helper::deleteFile($user->avatar, 'avatar');
            }
            $user->delete();

            return response()->json([
                'status'  => true,
                'message' => 'User berhasil dihapus',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage(),
            ]);
        }
    }
}
