<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = \Auth::user();

        if ($user->role->nama == 'admin') {
            return redirect()->route('admin.dashboard.index');
        }
        if ($user->role->nama == 'kepala sekolah') {
            return redirect()->route('admin.dashboard.index');
        }
        if ($user->role->nama == 'guru') {
            return redirect()->route('guru.dashboard.index');
        }
        if ($user->role->nama == 'siswa') {
            return redirect()->route('siswa.dashboard.index');
        }
        return view('home');
    }
}
