<?php
namespace App\Http\Controllers\Guru;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Services\Helper;
use App\Models\TahunPelajaran;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $rules = [

        // Data Pribadi & Identitas
        'nama'                 => 'required|string|max:150',
        'nip'                  => 'required|string|max:20|unique:guru,nip', // Tambahkan $this->guruId untuk handle update
        'nuptk'                => 'nullable|string|max:20|unique:guru,nuptk',
        'nik'                  => 'required|string|digits:16|unique:guru,nik',
        'no_kk'                => 'nullable|string|max:20',
        'npwp'                 => 'nullable|string|max:25',
        'jenis_kelamin'        => 'required|in:Laki-Laki,Perempuan',
        'tempat_lahir'         => 'required|string|max:100',
        'tanggal_lahir'        => 'required|date',
        'agama'                => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Khonghucu',
        'kewarganegaraan'      => 'required|string|max:50',

        // Data Kepegawaian
        'status_kepegawaian'   => 'required|in:PNS,PPPK,GTY,GTT,Honorer',
        'jenis_ptk'            => 'required|in:Kepala Sekolah,Wakil Kepala Sekolah,Guru Kelas,Guru Mata Pelajaran,Guru Bimbingan Konseling,Guru TIK,Guru Pendamping Khusus,Tenaga Administrasi Sekolah,Pustakawan,Laboran,Teknisi,Penjaga Sekolah,Lainnya',
        'tugas_tambahan'       => 'nullable|string|max:100',
        'no_sk_cpns'           => 'nullable|string|max:100',
        'sk_cpns'              => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:10240', // Validasi untuk file upload
        'tanggal_cpns'         => 'nullable|date',
        'no_sk_pengangkatan'   => 'required|string|max:100',
        'sk_pengangkatan'      => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:10240', // Validasi untuk file upload
        'tmt_pengangkatan'     => 'required|date',
        'lembaga_pengangkatan' => 'required|string|max:100',
        'pangkat_golongan'     => 'nullable|string|max:50',

        // Alamat
        'alamat_jalan'         => 'required|string',
        'rt'                   => 'nullable|string|max:5',
        'rw'                   => 'nullable|string|max:5',
        'nama_dusun'           => 'nullable|string|max:100',
        'desa_kelurahan'       => 'required|string|max:100',
        'kecamatan'            => 'required|string|max:100',
        'kabupaten'            => 'required|string|max:100',
        'provinsi'             => 'required|string|max:100',
        'kodepos'              => 'nullable|string|max:10',

        // Kontak & Akun
        'no_hp'                => 'nullable|string|max:20',
        'email'                => 'nullable|email|unique:guru,email',            // Cek unik di tabel guru dan user
        'foto'                 => 'nullable|image|mimes:jpeg,png,jpg|max:10240', // Validasi untuk file gambar
    ];

    public function index()
    {
        $guru   = Auth::user()->guru;
        $jadwal = $guru->jadwal;
        return view('guru.dashboard.index', compact('guru', 'jadwal'));
    }

    public function edit()
    {
        $guru = Auth::user()->guru;

        $jenisKelamin   = Helper::getEnumValues('users', 'jenis_kelamin');
        $agama          = Helper::getEnumValues('guru', 'agama');
        $tahunPelajaran = TahunPelajaran::orderBy('kode', 'desc')->get();
        $status         = Helper::getEnumValues('guru', 'status');

        $guru = $guru->load('user');
        return view('guru.dashboard.edit', compact('guru', 'agama', 'jenisKelamin', 'tahunPelajaran', 'status'));
    }

    public function update(Request $request)
    {
        try {
            $guru = Auth::user()->guru;

            $this->rules = array_merge($this->rules, [
                'email'                 => 'nullable|unique:users,email,' . $guru->user->id,
                'nip'                   => 'nullable|string|max:255|unique:guru,nip,' . $guru->id,
                'nuptk'                 => 'nullable|string|max:255|unique:guru,nuptk,' . $guru->id,
                'nik'                   => 'nullable|string|max:255|unique:guru,nik,' . $guru->id,
                'password'              => 'nullable|string|min:6|confirmed',
                'password_confirmation' => 'required_with:password',
            ]);

            $requestValidate = $request->validate($this->rules);

            \DB::beginTransaction();

            $user                = $guru->user;
            $user->username      = $request->username;
            $user->name          = $request->nama;
            $user->email         = $request->email;
            $user->jenis_kelamin = $request->jenis_kelamin;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            $requestValidate = Arr::except($requestValidate, ['username', 'email', 'password', 'password_confirmation']);

            $guru->update($requestValidate);

            if ($request->hasFile('foto')) {
                if ($guru->foto) {
                    Helper::deleteFile($guru->foto, 'foto_guru');
                }
                $guru->foto = Helper::uploadFile($request->file('foto'), $request->nama, 'foto_guru');
            }
            if ($request->hasFile('sk_cpns')) {
                if ($guru->sk_cpns) {
                    Helper::deleteFile($guru->sk_cpns, 'sk_cpns');
                }
                $guru->sk_cpns = Helper::uploadFile($request->file('sk_cpns'), $request->nama, 'sk_cpns');
            }
            if ($request->hasFile('sk_pengangkatan')) {
                if ($guru->sk_pengangkatan) {
                    Helper::deleteFile($guru->sk_pengangkatan, 'sk_pengangkatan');
                }
                $guru->sk_pengangkatan = Helper::uploadFile($request->file('sk_pengangkatan'), $request->nama, 'sk_pengangkatan');
            }

            $guru->save();

            \DB::commit();
            return redirect()->route('guru.dashboard.index')->with('success', 'Guru berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('guru.dashboard.edit', ['guru' => $guru])
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            \DB::rollback();
            return redirect()->route('guru.dashboard.edit', ['guru' => $guru])->with('error', $th->getMessage())->withInput();
        }
    }
}
