<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $tahunPelajaran = TahunPelajaran::orderBy('kode', 'desc')->get();
        return view('admin.jadwal.index', compact('tahunPelajaran'));
    }

    public function data(Request $request)
    {
        $kurikulum = Kurikulum::with([
            'detail' => function ($q) {
                $q->select('kurikulum_detail.*')
                    ->join('mata_pelajaran', 'kurikulum_detail.mata_pelajaran_id', '=', 'mata_pelajaran.id')
                    ->join('kelas', 'mata_pelajaran.kelas_id', '=', 'kelas.id')
                    ->orderBy('kelas.angka');
            },
            'detail.mataPelajaran.kelas',
        ])->get();

        $kurikulum = Kurikulum::with('detail.mataPelajaran.kelas')->get();

        $tahunPelajaran = TahunPelajaran::find($request->tahun_pelajaran_id);
        return view('admin.jadwal.kurikulum', compact('kurikulum', 'tahunPelajaran'));
    }
}
