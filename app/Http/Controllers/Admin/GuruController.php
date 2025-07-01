<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Helper;
use App\Models\Guru;
use App\Models\Role;
use App\Models\TahunPelajaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class GuruController extends Controller
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
        $jenisKelamin = Helper::getEnumValues('siswa', 'jenis_kelamin');

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
            ->editColumn('nama', function ($row) {
                $row->foto = $row->foto ? asset('foto_guru/' . $row->foto) : asset('template/assets/img/user.jpg');
                return '
                    <div class="d-flex align-items-center">
                        <img src="' . $row->foto . '" alt="Foto Guru" class="rounded-circle me-2" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <a href="' . route("admin.guru.edit", $row) . '">' . $row->nama . '</a><br>
                            <small>NIK: ' . ($row->nik ?? '-') . '</small><br>
                            <small>NIP: ' . ($row->nip ?? '-') . '</small>
                        </div>
                    </div>
                ';
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
            ->rawColumns(['action', 'nama'])
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
            // 1. Validasi input request berdasarkan rules yang ada
            $validatedData = $request->validate($this->rules);

            DB::beginTransaction();

            // 3. Membuat Akun User untuk Guru
            $role = Role::where('nama', 'guru')->first();
            if (! $role) {
                // Jika role 'guru' tidak ditemukan, batalkan proses dan beri pesan error
                throw new \Exception('Role "guru" tidak ditemukan. Silakan buat role terlebih dahulu.');
            }

            $password = Str::random(8); // Buat password acak
            $user     = User::create([
                'username'      => 'guru-' . time(),
                'name'          => $request->nama,
                'email'         => $request->email,
                'password'      => Hash::make($password),
                'role_id'       => $role->id,
                'jenis_kelamin' => $request->jenis_kelamin, // Hapus jika tidak ada di tabel users
            ]);

            // 4. Menyiapkan dan Menyimpan Data Guru
            $guru          = new Guru($validatedData);
            $guru->user_id = $user->id; // Menghubungkan guru dengan user yang baru dibuat

            // 5. Menangani File Upload
            // Menyimpan file foto jika diunggah
            if ($request->hasFile('foto')) {
                $guru->foto = Helper::uploadFile($request->file('foto'), $request->nama, 'foto_guru');
            }

            // Menyimpan file SK CPNS jika diunggah
            if ($request->hasFile('sk_cpns')) {
                $guru->sk_cpns = Helper::uploadFile($request->file('sk_cpns'), $request->nama, 'sk_cpns');
            }

            // Menyimpan file SK Pengangkatan jika diunggah
            if ($request->hasFile('sk_pengangkatan')) {
                $guru->sk_pengangkatan = Helper::uploadFile($request->file('sk_pengangkatan'), $request->nama, 'sk_pengangkatan');
            }

            $guru->save(); // Menyimpan semua data guru ke database

            DB::commit();

            $flashMessage = 'Data guru baru berhasil ditambahkan. Password untuk login: ' . $password;

            return redirect()->route('admin.guru.index')->with('success', $flashMessage);
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

    public function edit(Guru $guru)
    {
        $jenisKelamin   = Helper::getEnumValues('users', 'jenis_kelamin');
        $agama          = Helper::getEnumValues('guru', 'agama');
        $tahunPelajaran = TahunPelajaran::orderBy('kode', 'desc')->get();
        $status         = Helper::getEnumValues('guru', 'status');

        $guru = $guru->load('user');
        return view('admin.guru.edit', compact('guru', 'agama', 'jenisKelamin', 'tahunPelajaran', 'status'));
    }

    public function update(Request $request, Guru $guru)
    {
        try {
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
            return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil diupdate');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.guru.edit', ['guru' => $guru])
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', implode(' ', collect($e->errors())->flatten()->toArray()));
        } catch (\Throwable $th) {
            \DB::rollback();
            return redirect()->route('admin.guru.edit', ['guru' => $guru])->with('error', $th->getMessage())->withInput();
        }
    }

    public function destroy(Guru $guru)
    {
        try {
            if ($guru->foto) {
                Helper::deleteFile($guru->foto, 'foto');
            }
            if ($guru->sk_cpns) {
                Helper::deleteFile($guru->sk_cpns, 'sk_cpns');
            }
            if ($guru->sk_pengangkatan) {
                Helper::deleteFile($guru->sk_pengangkatan, 'sk_pengangkatan');
            }

            $guru->delete();
            $guru->user()->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Guru berhasil dihapus',
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

            Guru::whereIn('id', $validated['siswa_id'])
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
