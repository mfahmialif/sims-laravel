<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BobotNilai;
use App\Models\Jadwal;
use App\Models\KomponenNilai;
use Illuminate\Http\Request;

class NilaiBobotController extends Controller
{
    private $rules = [
        'bobot'             => 'required|array',
    ];

    public function index(Jadwal $jadwal)
    {
        $komponenNilai = KomponenNilai::orderBy('jenis', 'asc')->get();

        // Ambil semua bobot nilai untuk jadwal ini
        $bobotNilai = BobotNilai::where('jadwal_id', $jadwal->id)->get()->keyBy('komponen_nilai_id');

        $kelompokKomponen = [];

        foreach ($komponenNilai as $item) {
            $kelompokKomponen[$item->jenis][] = [
                'id'    => $item->id,
                'nama'  => $item->nama,
                'bobot' => optional($bobotNilai[$item->id] ?? null)->bobot ?? null,
            ];
        }

        return view('admin.nilai.bobot-nilai.index', compact('jadwal', 'kelompokKomponen'));
    }

    public function store(Request $request, Jadwal $jadwal)
    {
        try {
            $request->validate($this->rules);

            foreach ($request->bobot as $komponenNilaiId => $bobot) {
                BobotNilai::updateOrCreate(
                    [
                        'jadwal_id'         => $jadwal->id,
                        'komponen_nilai_id' => $komponenNilaiId,
                    ],
                    [
                        'bobot' => $bobot ?? 0,
                    ]
                );
            }

            return redirect()->route('admin.nilai.index')->with('success', 'Bobot Nilai berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.nilai.bobot-nilai.index', ['jadwal' => $jadwal])
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            return redirect()->route('admin.nilai.bobot-nilai.index', ['jadwal' => $jadwal])->with('error', $th->getMessage())->withInput();
        }
    }
}
