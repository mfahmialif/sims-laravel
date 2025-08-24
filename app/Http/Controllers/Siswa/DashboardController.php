<?php
namespace App\Http\Controllers\Siswa;

use App\Models\Kelas;
use App\Models\Kurikulum;
use Illuminate\Http\Request;
use App\Http\Services\Helper;
use App\Models\TahunPelajaran;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    protected $rules = [
        // Foreign Keys
        'email'                    => 'nullable|email|unique:users,email',

        // Informasi Siswa
        'nis'                      => 'nullable|string|max:255|unique:siswa,nis',
        'nisn'                     => 'nullable|string|max:255|unique:siswa,nisn',
        'nama_siswa'               => 'required|string|max:255',
        'jenis_kelamin'            => 'required|in:Laki-Laki,Perempuan',
        'tempat_lahir'             => 'required|string|max:255',
        'tanggal_lahir'            => 'required|date',
        'agama'                    => 'required|string|max:255',
        'nik_anak'                 => 'nullable|string|digits:16',
        'no_registrasi_akta_lahir' => 'nullable|string|max:255',
        'kk'                       => 'nullable|string|max:255',
        'akta_lahir_path'          => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:10240', // Diubah dari akta_lahir_path agar cocok dengan handle upload
        'anak_ke'                  => 'nullable|integer|min:1',
        'jumlah_saudara_kandung'   => 'nullable|integer|min:0',
        'umur_anak'                => 'nullable|integer|min:0',
        'masuk_sekolah_sebagai'    => 'nullable|string|max:255',
        'asal_sekolah_tk'          => 'nullable|string|max:255',
        'tinggi_badan'             => 'nullable|integer|min:0',
        'berat_badan'              => 'nullable|integer|min:0',
        'lingkar_kepala'           => 'nullable|integer|min:0',
        'jarak_tempuh_ke_sekolah'  => 'nullable|numeric|min:0',
        'gol_darah'                => 'nullable|string|max:10',
        'foto'                     => 'nullable|image|mimes:jpeg,png,jpg|max:10240',

        // Alamat Siswa
        'alamat_anak_sesuai_kk'    => 'required|string',
        'desa_kelurahan_anak'      => 'required|string|max:255',
        'kecamatan_anak'           => 'required|string|max:255',
        'kabupaten_anak'           => 'required|string|max:255',
        'kode_pos_anak'            => 'nullable|string|max:10',
        'rt_anak'                  => 'nullable|string|max:5',
        'rw_anak'                  => 'nullable|string|max:5',
        'lintang'                  => 'nullable|numeric',
        'bujur'                    => 'nullable|numeric',

        // Informasi Keluarga (Orang Tua)
        'nama_ayah'                => 'nullable|string|max:255',
        'nik_ayah'                 => 'nullable|string|digits:16',
        'tahun_lahir_ayah'         => 'nullable|digits:4|integer|min:1900',
        'pendidikan_ayah'          => 'nullable|string|max:255',
        'pekerjaan_ayah'           => 'nullable|string|max:255',
        'penghasilan_bulanan_ayah' => 'nullable|numeric|min:0',

        'nama_ibu_sesuai_ktp'      => 'nullable|string|max:255',
        'nik_ibu'                  => 'nullable|string|digits:16',
        'tahun_lahir_ibu'          => 'nullable|digits:4|integer|min:1900',
        'pendidikan_ibu'           => 'nullable|string|max:255',
        'pekerjaan_ibu'            => 'nullable|string|max:255',
        'penghasilan_bulanan_ibu'  => 'nullable|numeric|min:0',

        // Alamat Keluarga
        'alamat_ortu_sesuai_kk'    => 'nullable|string',
        'kelurahan_ortu'           => 'nullable|string|max:255',
        'kecamatan_ortu'           => 'nullable|string|max:255',
        'kabupaten_ortu'           => 'nullable|string|max:255',
        'no_kartu_keluarga'        => 'nullable|string|max:255',

        'tinggal_bersama'          => 'nullable|string|max:255',
        'transportasi_ke_sekolah'  => 'nullable|string|max:255',
        'nomor_telepon_orang_tua'  => 'nullable|string|max:20',

        // Informasi Wali
        'nama_wali'                => 'nullable|string|max:255',
        'nik_wali'                 => 'nullable|string|digits:16',
        'tahun_lahir_wali'         => 'nullable|digits:4|integer|min:1900',
        'pendidikan_wali'          => 'nullable|string|max:255',
        'pekerjaan_wali'           => 'nullable|string|max:255',
        'penghasilan_bulanan_wali' => 'nullable|numeric|min:0',
        'alamat_wali'              => 'nullable|string',
        'rt_wali'                  => 'nullable|string|max:5',
        'rw_wali'                  => 'nullable|string|max:5',
        'desa_kelurahan_wali'      => 'nullable|string|max:255',
        'kecamatan_wali'           => 'nullable|string|max:255',
        'kabupaten_wali'           => 'nullable|string|max:255',
        'kode_pos_wali'            => 'nullable|string|max:10',
        'nomor_telepon_wali'       => 'nullable|string|max:20',

    ];

    public function index()
    {
        $siswa      = \Auth::user()->siswa;
        $kelasSiswa = $siswa->kelasSiswa;
        return view('siswa.dashboard.index', compact('siswa', 'kelasSiswa'));
    }

    public function edit()
    {
        $siswa      = \Auth::user()->siswa;
        $jenisKelamin   = Helper::getEnumValues('users', 'jenis_kelamin');
        $agama          = Helper::getEnumValues('siswa', 'agama');
        $tahunPelajaran = TahunPelajaran::orderBy('kode', 'desc')->get();
        $status         = Helper::getEnumValues('siswa', 'status');
        $kelas          = Kelas::orderBy('angka')->get();
        $kurikulum      = Kurikulum::all();

        $siswa = $siswa->load('user');
        return view('siswa.dashboard.edit', compact('siswa', 'agama', 'jenisKelamin', 'tahunPelajaran', 'status', 'kelas', 'kurikulum'));
    }

    public function update(Request $request)
    {
        try {
            $siswa = \Auth::user()->siswa;
            $this->rules = array_merge($this->rules, [
                'email' => 'nullable|unique:users,email,' . $siswa->user->id,
                'nis'   => 'nullable|string|max:255|unique:siswa,nis,' . $siswa->id,
                'nisn'  => 'nullable|string|max:255|unique:siswa,nisn,' . $siswa->id,
            ]);

            $request->validate($this->rules);

            \DB::beginTransaction();

            $user                = $siswa->user;
            $user->name          = $request->nama_siswa;
            $user->email         = $request->email;
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->save();

            $umur = $request->tanggal_lahir ? Helper::hitungUmur($request->tanggal_lahir) : null;

            // Mengisi Informasi Siswa
            $siswa->nis                      = $request->nis;
            $siswa->nisn                     = $request->nisn;
            $siswa->nama_siswa               = $request->nama_siswa;
            $siswa->jenis_kelamin            = $request->jenis_kelamin;
            $siswa->tempat_lahir             = $request->tempat_lahir;
            $siswa->tanggal_lahir            = $request->tanggal_lahir;
            $siswa->agama                    = $request->agama;
            $siswa->nik_anak                 = $request->nik_anak;
            $siswa->no_registrasi_akta_lahir = $request->no_registrasi_akta_lahir;
            $siswa->kk                       = $request->kk;
            $siswa->anak_ke                  = $request->anak_ke;
            $siswa->jumlah_saudara_kandung   = $request->jumlah_saudara_kandung;
            $siswa->umur_anak                = $umur;
            $siswa->masuk_sekolah_sebagai    = $request->masuk_sekolah_sebagai;
            $siswa->asal_sekolah_tk          = $request->asal_sekolah_tk;
            $siswa->tinggi_badan             = $request->tinggi_badan;
            $siswa->berat_badan              = $request->berat_badan;
            $siswa->lingkar_kepala           = $request->lingkar_kepala;
            $siswa->jarak_tempuh_ke_sekolah  = $request->jarak_tempuh_ke_sekolah;
            $siswa->gol_darah                = $request->gol_darah;

            // Mengisi Alamat Siswa
            $siswa->alamat_anak_sesuai_kk = $request->alamat_anak_sesuai_kk;
            $siswa->desa_kelurahan_anak   = $request->desa_kelurahan_anak;
            $siswa->kecamatan_anak        = $request->kecamatan_anak;
            $siswa->kabupaten_anak        = $request->kabupaten_anak;
            $siswa->kode_pos_anak         = $request->kode_pos_anak;
            $siswa->rt_anak               = $request->rt_anak;
            $siswa->rw_anak               = $request->rw_anak;
            $siswa->lintang               = $request->lintang;
            $siswa->bujur                 = $request->bujur;

            // Mengisi Informasi Keluarga (Orang Tua)
            $siswa->nama_ayah                = $request->nama_ayah;
            $siswa->nik_ayah                 = $request->nik_ayah;
            $siswa->tahun_lahir_ayah         = $request->tahun_lahir_ayah;
            $siswa->pendidikan_ayah          = $request->pendidikan_ayah;
            $siswa->pekerjaan_ayah           = $request->pekerjaan_ayah;
            $siswa->penghasilan_bulanan_ayah = $request->penghasilan_bulanan_ayah;

            $siswa->nama_ibu_sesuai_ktp     = $request->nama_ibu_sesuai_ktp;
            $siswa->nik_ibu                 = $request->nik_ibu;
            $siswa->tahun_lahir_ibu         = $request->tahun_lahir_ibu;
            $siswa->pendidikan_ibu          = $request->pendidikan_ibu;
            $siswa->pekerjaan_ibu           = $request->pekerjaan_ibu;
            $siswa->penghasilan_bulanan_ibu = $request->penghasilan_bulanan_ibu;

            // Mengisi Alamat Keluarga
            $siswa->alamat_ortu_sesuai_kk = $request->alamat_ortu_sesuai_kk;
            $siswa->kelurahan_ortu        = $request->kelurahan_ortu;
            $siswa->kecamatan_ortu        = $request->kecamatan_ortu;
            $siswa->kabupaten_ortu        = $request->kabupaten_ortu;
            $siswa->no_kartu_keluarga     = $request->no_kartu_keluarga;

            $siswa->tinggal_bersama         = $request->tinggal_bersama;
            $siswa->transportasi_ke_sekolah = $request->transportasi_ke_sekolah;
            $siswa->nomor_telepon_orang_tua = $request->nomor_telepon_orang_tua;

            // Mengisi Informasi Wali (Jika ada)
            $siswa->nama_wali                = $request->nama_wali;
            $siswa->nik_wali                 = $request->nik_wali;
            $siswa->tahun_lahir_wali         = $request->tahun_lahir_wali;
            $siswa->pendidikan_wali          = $request->pendidikan_wali;
            $siswa->pekerjaan_wali           = $request->pekerjaan_wali;
            $siswa->penghasilan_bulanan_wali = $request->penghasilan_bulanan_wali;
            $siswa->alamat_wali              = $request->alamat_wali;
            $siswa->rt_wali                  = $request->rt_wali;
            $siswa->rw_wali                  = $request->rw_wali;
            $siswa->desa_kelurahan_wali      = $request->desa_kelurahan_wali;
            $siswa->kecamatan_wali           = $request->kecamatan_wali;
            $siswa->kabupaten_wali           = $request->kabupaten_wali;
            $siswa->kode_pos_wali            = $request->kode_pos_wali;
            $siswa->nomor_telepon_wali       = $request->nomor_telepon_wali;

            if ($request->hasFile('foto')) {
                if ($siswa->foto) {
                    Helper::deleteFile($siswa->foto, 'foto_siswa');
                }
                $siswa->foto = Helper::uploadFile($request->file('foto'), $request->nama_siswa, 'foto_siswa');
            }

            if ($request->hasFile('akta_lahir_path')) {
                if ($siswa->akta_lahir_path) {
                    Helper::deleteFile($siswa->akta_lahir_path, 'akta_lahir_path');
                }
                $siswa->akta_lahir_path = Helper::uploadFile($request->file('akta_lahir_path'), $request->nama_siswa, 'akta_lahir_path');
            }

            $siswa->save();

            \DB::commit();
            return redirect()->route('siswa.dashboard.index')->with('success', 'Siswa berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('siswa.dashboard.edit')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            \DB::rollback();
            return redirect()->route('siswa.dashboard.edit')->with('error', $th->getMessage())->withInput();
        }
    }
}
