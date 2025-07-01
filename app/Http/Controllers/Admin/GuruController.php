<?php
namespace App\Http\Controllers\Admin;

use App\Models\Guru;
use App\Models\Role;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Services\Helper;
use App\Models\TahunPelajaran;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    protected $rules = [
        // Foreign Keys
        'user_id'              => 'required|exists:users,id',

        // Data Pribadi & Identitas
        'nama'                 => 'required|string|max:150',
        'nip'                  => 'required|string|max:20|unique', // Tambahkan $this->guruId untuk handle update
        'nuptk'                => 'nullable|string|max:20|unique',
        'nik'                  => 'required|string|digits:16|unique',
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
        'email'                => 'nullable|email|unique',                       // Cek unik di tabel guru dan user
        'foto'                 => 'nullable|image|mimes:jpeg,png,jpg|max:10240', // Validasi untuk file gambar
    ];

    public function index()
    {
        $jenisKelamin   = Helper::getEnumValues('siswa', 'jenis_kelamin');

        return view('admin.guru.index', compact('jenisKelamin'));
    }

    public function data(Request $request)
    {
        $search = request('search.value');
        $data   = Guru::select('*');
        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->when($request->jenis_kelamin, function ($q) use ($request) {
                    $q->where('jenis_kelamin', $request->jenis_kelamin);
                });
                $query->where(function ($query) use ($search) {
                    $query->orWhere('nama', 'LIKE', "%$search%");
                    $query->orWhere('jenis_kelamin', 'LIKE', "%$search%");
                });
            })
            ->editColumn('nama_siswa', function ($row) {
                $row->foto = $row->foto ? asset('foto_guru/' . $row->foto) : asset('template/assets/img/user.jpg');
                return '
                    <div class="d-flex align-items-center">
                        <img src="' . $row->foto . '" alt="Foto Guru" class="rounded-circle me-2" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <a href="' . route("admin.guru.edit", $row) . '">' . $row->nama . '</a><br>
                        </div>
                    </div>
                ';
            })
            ->editColumn('status_daftar', function ($row) {
                return '<span class="badge bg-' . Helper::getColorStatus($row->status_daftar) . '">' . strtoupper($row->status_daftar) . '</span>';
            })
            ->addColumn('action', function ($row) {
                $content = '<div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="' . route("admin.guru.edit", $row) . '"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
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
            ->rawColumns(['action', 'nama_siswa', 'status_daftar'])
            ->toJson();
    }

    public function add()
    {
        $jenisKelamin   = Helper::getEnumValues('users', 'jenis_kelamin');
        $agama          = Helper::getEnumValues('siswa', 'agama');
        $tahunPelajaran = TahunPelajaran::orderBy('kode', 'desc')->get();
        $statusDaftar   = Helper::getEnumValues('siswa', 'status_daftar');
        return view('admin.guru.add', compact('jenisKelamin', 'agama', 'tahunPelajaran', 'statusDaftar'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate($this->rules);

            \DB::beginTransaction();
            $role = Role::where('nama', 'siswa')->first();

            //random password
            $password = Str::random(8);
            $user     = User::create([
                'username'      => 'sis-' . time(),
                'name'          => $request->nama_siswa,
                'email'         => $request->email,
                'password'      => Hash::make($password),
                'jenis_kelamin' => $request->jenis_kelamin,
                'role_id'       => $role->id,
            ]);

            $umur  = $request->tanggal_lahir ? Helper::hitungUmur($request->tanggal_lahir) : null;
            $siswa = new Siswa();

            // Mengisi Foreign Keys
            $siswa->tahun_pelajaran_id = $request->tahun_pelajaran_id;
            $siswa->user_id            = $user->id;

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

                                                                         // Mengisi Status
            $siswa->status_daftar = $request->status_daftar ?? 'daftar'; // Default 'daftar' jika tidak ada input
            $siswa->status        = $request->input('status', 'aktif');  // Default 'aktif' jika tidak ada input

            if ($request->hasFile('foto')) {
                $siswa->foto = Helper::uploadFile($request->file('foto'), $request->nama_siswa, 'foto_guru');
            }


            $siswa->save();

            \DB::commit();
            return redirect()->route('admin.guru.index')->with('success', 'Data siswa baru berhasil ditambahkan.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \DB::rollback();
            return redirect()->route('admin.guru.add')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            \DB::rollback();
            return redirect()->route('admin.guru.add')
                ->with('error', 'Terjadi kesalahan: ' . $th->getMessage())
                ->withInput();
        }
    }

    public function edit(Siswa $siswa)
    {
        $jenisKelamin   = Helper::getEnumValues('users', 'jenis_kelamin');
        $agama          = Helper::getEnumValues('siswa', 'agama');
        $tahunPelajaran = TahunPelajaran::orderBy('kode', 'desc')->get();
        $statusDaftar   = Helper::getEnumValues('siswa', 'status_daftar');

        $siswa = $siswa->load('user');
        return view('admin.guru.edit', compact('siswa', 'agama', 'jenisKelamin', 'tahunPelajaran', 'statusDaftar'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        try {
            $this->rules = array_merge($this->rules, [
                'email' => 'nullable|unique:users,email,' . $siswa->user->id,
                'nis'   => 'nullable|string|max:255|unique:siswa,nis,' . $siswa->id,
                'nisn'  => 'nullable|string|max:255|unique:siswa,nisn,' . $siswa->id,
            ]);

            $request->validate($this->rules);

            \DB::beginTransaction();

            $user                = $siswa->user;
            $user->email         = $request->email;
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->save();

            $umur = $request->tanggal_lahir ? Helper::hitungUmur($request->tanggal_lahir) : null;

            // Mengisi Foreign Keys
            $siswa->tahun_pelajaran_id = $request->tahun_pelajaran_id;

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

                                                                                // Mengisi Status
            $siswa->status_daftar = $request->input('status_daftar', 'daftar'); // Default 'daftar' jika tidak ada input
            $siswa->status        = $request->input('status', 'aktif');         // Default 'aktif' jika tidak ada input

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
            return redirect()->route('admin.guru.index')->with('success', 'Siswa berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.guru.edit', ['siswa' => $siswa])
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            \DB::rollback();
            return redirect()->route('admin.guru.edit', ['siswa' => $siswa])->with('error', $th->getMessage())->withInput();
        }
    }

    public function destroy(Siswa $siswa)
    {
        try {
            if ($siswa->foto) {
                Helper::deleteFile($siswa->foto, 'foto');
            }
            if ($siswa->akta_lahir_path) {
                Helper::deleteFile($siswa->akta_lahir_path, 'akta_lahir_path');
            }

            $siswa->delete();
            $siswa->user()->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Siswa berhasil dihapus',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function updateStatusDaftar(Request $request)
    {
        try {
            $validated = $request->validate([
                'siswa_id'      => 'required|array',
                'siswa_id.*'    => 'integer|exists:siswa,id', // pastikan setiap id valid
                'status_daftar' => 'required|string',         // tambahkan validasi untuk status
            ]);

            Siswa::whereIn('id', $validated['siswa_id'])
                ->update([
                    'status_daftar' => $validated['status_daftar'],
                ]);

            return response()->json([
                'status'  => true,
                'message' => 'Berhasil mengupdate status daftar',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status'  => false,
                'message' => 422,
                'errors'  => $e->errors(), // kirim array error lengkap
                'req'     => $request->all(),
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage(),
                'request' => $request->all(),
            ], 500);
        }
    }
}
