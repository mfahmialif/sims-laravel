<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Helper;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
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
        $jenisKelamin = Helper::getEnumValues('users', 'jenis_kelamin');
        $role         = Role::all();
        $user         = Auth::user();
        return view('admin.profile.index', compact('user', 'role', 'jenisKelamin'));
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::user();
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
                    Helper::deleteFile($user->avatar, 'avatar');
                }
                $user->avatar = Helper::uploadFile($request->file('avatar'), $request->username, 'avatar');
            }

            $user->save();
            return redirect()->route('admin.profile.index')->with('success', 'User berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.profile.index')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.profile.index')->with('error', $th->getMessage())->withInput();
        }
    }

}
