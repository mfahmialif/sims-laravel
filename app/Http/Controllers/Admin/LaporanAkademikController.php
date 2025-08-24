<?php
namespace App\Http\Controllers\Admin;

use App\Models\Kelas;
use App\Models\Jadwal;
use App\Models\KelasSub;
use App\Exports\ExcelExport;
use Illuminate\Http\Request;
use App\Models\TahunPelajaran;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class LaporanAkademikController extends Controller
{
    public function index()
    {
        $tahunPelajaran = TahunPelajaran::all();
        $kelas          = Kelas::all();
        $kelasSub       = KelasSub::all();
        return view('admin.laporan-akademik.index', compact('tahunPelajaran', 'kelas', 'kelasSub'));
    }

    public function laporanJadwal(Request $request)
    {
        $data = Jadwal::join('guru', 'guru.id', '=', 'jadwal.guru_id')
            ->join('kelas_sub', 'kelas_sub.id', '=', 'jadwal.kelas_sub_id')
            ->join('kelas', 'kelas.id', '=', 'kelas_sub.kelas_id')
            ->join('tahun_pelajaran', 'tahun_pelajaran.id', '=', 'jadwal.tahun_pelajaran_id')
            ->join('kurikulum_detail', 'kurikulum_detail.id', '=', 'jadwal.kurikulum_detail_id')
            ->join('kurikulum', 'kurikulum.id', '=', 'kurikulum_detail.kurikulum_id')
            ->join('mata_pelajaran', 'mata_pelajaran.id', '=', 'kurikulum_detail.mata_pelajaran_id')
            ->when($request->tahun_pelajaran_id, function ($query) use ($request) {
                return $query->where('tahun_pelajaran.id', $request->tahun_pelajaran_id);
            })
            ->when($request->kelas_id, function ($query) use ($request) {
                return $query->where('kelas.id', $request->kelas_id);
            })
            ->when($request->kelas_sub_id, function ($query) use ($request) {
                return $query->where('kelas_sub.id', $request->kelas_sub_id);
            })
            ->select('tahun_pelajaran.nama as tahun', 'tahun_pelajaran.semester', 'mata_pelajaran.kode', 'mata_pelajaran.nama as mapel', 'kelas.angka as kelas', 'kelas_sub.sub', 'guru.nama as guru', 'guru.nip', 'jadwal.hari', 'jadwal.jam_mulai', 'jadwal.jam_selesai')
            ->get();

        if ($request->submit == 'excel') {
            return Excel::download(new ExcelExport($data, ['I']), 'laporan-jadwal.xlsx');
        } else {
            $pdf = Pdf::loadView('admin.laporan-akademik.cetak-jadwal', compact('data'));
            return $pdf->stream('laporan-jadwal.pdf');
        }
    }
}
