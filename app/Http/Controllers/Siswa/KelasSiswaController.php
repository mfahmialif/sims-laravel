<?php
namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Http\Services\Helper;
use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\KelasSub;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KelasSiswaController extends Controller
{
    private $rules = [
        "siswa_id" => "required",
    ];

    public function index(KelasSub $kelasSub)
    {
        return view('siswa.kelas.index', compact('kelasSub'));
    }

    public function data(Request $request, KelasSub $kelasSub)
    {
        $search = request('search.value');
        $data   = KelasSiswa::join('kelas_sub', 'kelas_sub.id', '=', 'kelas_siswa.kelas_sub_id')
            ->join('kelas', 'kelas.id', '=', 'kelas_sub.kelas_id')
            ->join('siswa', 'siswa.id', '=', 'kelas_siswa.siswa_id')
            ->where('kelas_siswa.kelas_sub_id', $kelasSub->id)
            ->select('kelas_siswa.*',
                'kelas.angka as kelas_angka',
                'kelas_sub.sub',
                'kelas.id as kelas_id',
                'siswa.nama_siswa',
                'siswa.foto',
                'siswa.nis',
                'siswa.nisn',
                'siswa.jenis_kelamin'
            );
        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('kelas_sub.sub', 'LIKE', "%$search%");
                    $query->orWhere('kelas.romawi', 'LIKE', "%$search%");
                    $query->orWhere('kelas.angka', 'LIKE', "%$search%");
                });
            })
            ->editColumn('nama_siswa', function ($row) {
                $row->foto = $row->foto ? asset('foto_siswa/' . $row->foto) : asset('template/assets/img/user.jpg');
                return '
                    <div class="d-flex align-items-center">
                        <img src="' . $row->foto . '" alt="Foto Siswa" class="rounded-circle me-2" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <span>' . $row->nama_siswa . '</span><br>
                            <small>NIS: ' . ($row->nis ?? '-') . '</small><br>
                            <small>' . ($row->jenis_kelamin ?? '-') . '</small>
                        </div>
                    </div>
                ';
            })
            ->rawColumns(['nama_siswa'])
            ->toJson();
    }
}
