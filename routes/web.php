<?php

use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Admin\AbsensiRekapController;
use App\Http\Controllers\Admin\CetakLaporanController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\JadwalDetailController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\KelasSiswaController;
use App\Http\Controllers\Admin\KelasSubController;
use App\Http\Controllers\Admin\KelasWaliController;
use App\Http\Controllers\Admin\KepalaSekolahController;
use App\Http\Controllers\Admin\KurikulumController;
use App\Http\Controllers\Admin\LaporanAkademikController;
use App\Http\Controllers\Admin\MataPelajaranController;
use App\Http\Controllers\Admin\NilaiBobotController;
use App\Http\Controllers\Admin\NilaiController;
use App\Http\Controllers\Admin\NilaiInputController;
use App\Http\Controllers\Admin\PendaftaranSiswaBaruController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\TahunPelajaranController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Guru\AbsensiController as GuruAbsensiController;
use App\Http\Controllers\Guru\AbsensiRekapController as GuruAbsensiRekapController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\NilaiBobotController as GuruNilaiBobotController;
use App\Http\Controllers\Guru\NilaiController as GuruNilaiController;
use App\Http\Controllers\Guru\NilaiInputController as GuruNilaiInputController;
use App\Http\Controllers\Guru\ProfileController as GuruProfileController;
use App\Http\Controllers\Guru\SiswaController as GuruSiswaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Siswa\AbsensiController as SiswaAbsensiController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\NilaiController as SiswaNilaiController;
use App\Http\Controllers\Siswa\ProfileController as SiswaProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// remake halaman utama menjadi login
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']);

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::prefix('pendaftaran-siswa-baru')->group(function () {
            Route::get('/', [PendaftaranSiswaBaruController::class, 'index'])->name('admin.pendaftaran-siswa-baru.index');
            Route::get('/data', [PendaftaranSiswaBaruController::class, 'data'])->name('admin.pendaftaran-siswa-baru.data');
            Route::get('/add', [PendaftaranSiswaBaruController::class, 'add'])->name('admin.pendaftaran-siswa-baru.add');
            Route::post('/', [PendaftaranSiswaBaruController::class, 'store'])->name('admin.pendaftaran-siswa-baru.store');
            Route::put('/update-status-daftar', [PendaftaranSiswaBaruController::class, 'updateStatusDaftar'])->name('admin.pendaftaran-siswa-baru.update-status-daftar');
            Route::get('/{siswa}/edit', [PendaftaranSiswaBaruController::class, 'edit'])->name('admin.pendaftaran-siswa-baru.edit');
            Route::put('/{siswa}/update', [PendaftaranSiswaBaruController::class, 'update'])->name('admin.pendaftaran-siswa-baru.update');
            Route::delete('/{siswa}/destroy', [PendaftaranSiswaBaruController::class, 'destroy'])->name('admin.pendaftaran-siswa-baru.destroy');
        });
        Route::prefix('siswa')->group(function () {
            Route::get('/', [SiswaController::class, 'index'])->name('admin.siswa.index');
            Route::get('/data', [SiswaController::class, 'data'])->name('admin.siswa.data');
            Route::put('/update-status', [SiswaController::class, 'updateStatus'])->name('admin.siswa.update-status');
            Route::get('/{siswa}/show', [SiswaController::class, 'show'])->name('admin.siswa.show');
            Route::get('/{siswa}/absensi/{jadwal}', [SiswaController::class, 'absensi'])->name('admin.siswa.absensi');
            Route::get('/{siswa}/nilai/{jadwal}', [SiswaController::class, 'nilai'])->name('admin.siswa.nilai');
            Route::get('/{siswa}/edit', [SiswaController::class, 'edit'])->name('admin.siswa.edit');
            Route::put('/{siswa}/update', [SiswaController::class, 'update'])->name('admin.siswa.update');
            Route::delete('/{siswa}/destroy', [SiswaController::class, 'destroy'])->name('admin.siswa.destroy');
        });
        Route::prefix('absensi')->group(function () {
            Route::get('/', [AbsensiController::class, 'index'])->name('admin.absensi.index');
            Route::get('/data', [AbsensiController::class, 'data'])->name('admin.absensi.data');

            Route::prefix('{jadwal}/rekap')->group(function () {
                Route::get('/', [AbsensiRekapController::class, 'index'])->name('admin.absensi.rekap.index');
                Route::get('/data', [AbsensiRekapController::class, 'data'])->name('admin.absensi.rekap.data');
                Route::get('/data-form', [AbsensiRekapController::class, 'dataForm'])->name('admin.absensi.rekap.data-form');
                Route::get('/add', [AbsensiRekapController::class, 'add'])->name('admin.absensi.rekap.add');
                Route::post('/', [AbsensiRekapController::class, 'store'])->name('admin.absensi.rekap.store');
                Route::get('/{absensi}/edit', [AbsensiRekapController::class, 'edit'])->name('admin.absensi.rekap.edit');
                Route::get('/{absensi}/data-form', [AbsensiRekapController::class, 'dataFormEdit'])->name('admin.absensi.rekap.data-form-edit');
                Route::put('/{absensi}/update', [AbsensiRekapController::class, 'update'])->name('admin.absensi.rekap.update');
                Route::delete('/{absensi}/destroy', [AbsensiRekapController::class, 'destroy'])->name('admin.absensi.rekap.destroy');
            });
        });
        Route::prefix('nilai')->group(function () {
            Route::get('/', [NilaiController::class, 'index'])->name('admin.nilai.index');
            Route::get('/data', [NilaiController::class, 'data'])->name('admin.nilai.data');

            Route::prefix('{jadwal}')->group(function () {
                Route::prefix('bobot-nilai')->group(function () {
                    Route::get('/', [NilaiBobotController::class, 'index'])->name('admin.nilai.bobot-nilai.index');
                    Route::post('/', [NilaiBobotController::class, 'store'])->name('admin.nilai.bobot-nilai.store');
                });

                Route::prefix('input')->group(function () {
                    Route::get('/', [NilaiInputController::class, 'index'])->name('admin.nilai.input.index');
                    Route::post('/', [NilaiInputController::class, 'store'])->name('admin.nilai.input.store');
                    Route::get('/data-form', [NilaiInputController::class, 'dataForm'])->name('admin.nilai.input.data-form');
                });
            });
        });
        Route::prefix('guru')->group(function () {
            Route::get('/', [GuruController::class, 'index'])->name('admin.guru.index');
            Route::get('/data', [GuruController::class, 'data'])->name('admin.guru.data');
            Route::get('/add', [GuruController::class, 'add'])->name('admin.guru.add');
            Route::post('/', [GuruController::class, 'store'])->name('admin.guru.store');
            Route::put('/update-status-daftar', [GuruController::class, 'updateStatusDaftar'])->name('admin.guru.update-status-daftar');
            Route::get('/{guru}/edit', [GuruController::class, 'edit'])->name('admin.guru.edit');
            Route::put('/{guru}/update', [GuruController::class, 'update'])->name('admin.guru.update');
            Route::delete('/{guru}/destroy', [GuruController::class, 'destroy'])->name('admin.guru.destroy');
            Route::get('/{guru}/show', [GuruController::class, 'show'])->name('admin.guru.show');
        });
        Route::prefix('kepala-sekolah')->group(function () {
            Route::get('/', [KepalaSekolahController::class, 'index'])->name('admin.kepala-sekolah.index');
            Route::get('/data', [KepalaSekolahController::class, 'data'])->name('admin.kepala-sekolah.data');
            Route::get('/autocomplete/{query}', [KepalaSekolahController::class, 'autocomplete'])->name('admin.kepala-sekolah.autocomplete');
            Route::get('/add', [KepalaSekolahController::class, 'add'])->name('admin.kepala-sekolah.add');
            Route::post('/', [KepalaSekolahController::class, 'store'])->name('admin.kepala-sekolah.store');
            Route::put('/update-status-daftar', [KepalaSekolahController::class, 'updateStatusDaftar'])->name('admin.kepala-sekolah.update-status-daftar');
            Route::get('/{kepalaSekolah}/edit', [KepalaSekolahController::class, 'edit'])->name('admin.kepala-sekolah.edit');
            Route::put('/{kepalaSekolah}/update', [KepalaSekolahController::class, 'update'])->name('admin.kepala-sekolah.update');
            Route::delete('/{kepalaSekolah}/destroy', [KepalaSekolahController::class, 'destroy'])->name('admin.kepala-sekolah.destroy');
        });
        Route::prefix('kelas')->group(function () {
            Route::get('/', [KelasController::class, 'index'])->name('admin.kelas.index');
            Route::get('/data', [KelasController::class, 'data'])->name('admin.kelas.data');
            Route::get('/add', [KelasController::class, 'add'])->name('admin.kelas.add');
            Route::post('/', [KelasController::class, 'store'])->name('admin.kelas.store');
            Route::get('/{kelas}/edit', [KelasController::class, 'edit'])->name('admin.kelas.edit');
            Route::put('/{kelas}/update', [KelasController::class, 'update'])->name('admin.kelas.update');
            Route::delete('/{kelas}/destroy', [KelasController::class, 'destroy'])->name('admin.kelas.destroy');

            Route::prefix('{kelas}/sub')->group(function () {
                Route::get('/', [KelasSubController::class, 'index'])->name('admin.kelas.sub.index');
                Route::get('/data', [KelasSubController::class, 'data'])->name('admin.kelas.sub.data');
                Route::get('/add', [KelasSubController::class, 'add'])->name('admin.kelas.sub.add');
                Route::post('/', [KelasSubController::class, 'store'])->name('admin.kelas.sub.store');
                Route::get('/{kelasSub}/edit', [KelasSubController::class, 'edit'])->name('admin.kelas.sub.edit');
                Route::put('/{kelasSub}/update', [KelasSubController::class, 'update'])->name('admin.kelas.sub.update');
                Route::delete('/{kelasSub}/destroy', [KelasSubController::class, 'destroy'])->name('admin.kelas.sub.destroy');

                Route::prefix('{kelasSub}/wali')->group(function () {
                    Route::get('/', [KelasWaliController::class, 'index'])->name('admin.kelas.sub.wali.index');
                    Route::get('/data', [KelasWaliController::class, 'data'])->name('admin.kelas.sub.wali.data');
                    Route::get('/add', [KelasWaliController::class, 'add'])->name('admin.kelas.sub.wali.add');
                    Route::post('/', [KelasWaliController::class, 'store'])->name('admin.kelas.sub.wali.store');
                    Route::get('/{kelasWali}/edit', [KelasWaliController::class, 'edit'])->name('admin.kelas.sub.wali.edit');
                    Route::put('/{kelasWali}/update', [KelasWaliController::class, 'update'])->name('admin.kelas.sub.wali.update');
                    Route::delete('/{kelasWali}/destroy', [KelasWaliController::class, 'destroy'])->name('admin.kelas.sub.wali.destroy');
                });
                Route::prefix('{kelasSub}/siswa')->group(function () {
                    Route::get('/', [KelasSiswaController::class, 'index'])->name('admin.kelas.sub.siswa.index');
                    Route::get('/data', [KelasSiswaController::class, 'data'])->name('admin.kelas.sub.siswa.data');
                    Route::get('/data-siswa', [KelasSiswaController::class, 'dataSiswa'])->name('admin.kelas.sub.siswa.data-siswa');
                    Route::get('/add', [KelasSiswaController::class, 'add'])->name('admin.kelas.sub.siswa.add');
                    Route::post('/', [KelasSiswaController::class, 'store'])->name('admin.kelas.sub.siswa.store');
                    Route::delete('/bulk-destroy', [KelasSiswaController::class, 'bulkDestroy'])->name('admin.kelas.sub.siswa.bulk-destroy');
                    Route::get('/{kelasSiswa}/edit', [KelasSiswaController::class, 'edit'])->name('admin.kelas.sub.siswa.edit');
                    Route::put('/{kelasSiswa}/update', [KelasSiswaController::class, 'update'])->name('admin.kelas.sub.siswa.update');
                    Route::delete('/{kelasSiswa}/destroy', [KelasSiswaController::class, 'destroy'])->name('admin.kelas.sub.siswa.destroy');
                });
            });
        });
        Route::prefix('mata-pelajaran')->group(function () {
            Route::get('/', [MataPelajaranController::class, 'index'])->name('admin.mata-pelajaran.index');
            Route::get('/data', [MataPelajaranController::class, 'data'])->name('admin.mata-pelajaran.data');
            Route::get('/add', [MataPelajaranController::class, 'add'])->name('admin.mata-pelajaran.add');
            Route::post('/', [MataPelajaranController::class, 'store'])->name('admin.mata-pelajaran.store');
            Route::get('/{mataPelajaran}/edit', [MataPelajaranController::class, 'edit'])->name('admin.mata-pelajaran.edit');
            Route::put('/{mata-pelajaran}/update', [MataPelajaranController::class, 'update'])->name('admin.mata-pelajaran.update');
            Route::delete('/{mataPelajaran}/destroy', [MataPelajaranController::class, 'destroy'])->name('admin.mata-pelajaran.destroy');
        });
        Route::prefix('tahun-pelajaran')->group(function () {
            Route::get('/', [TahunPelajaranController::class, 'index'])->name('admin.tahun-pelajaran.index');
            Route::get('/data', [TahunPelajaranController::class, 'data'])->name('admin.tahun-pelajaran.data');
            Route::get('/add', [TahunPelajaranController::class, 'add'])->name('admin.tahun-pelajaran.add');
            Route::post('/', [TahunPelajaranController::class, 'store'])->name('admin.tahun-pelajaran.store');
            Route::get('/{tahunPelajaran}/edit', [TahunPelajaranController::class, 'edit'])->name('admin.tahun-pelajaran.edit');
            Route::put('/{tahunPelajaran}/update', [TahunPelajaranController::class, 'update'])->name('admin.tahun-pelajaran.update');
            Route::delete('/{tahunPelajaran}/destroy', [TahunPelajaranController::class, 'destroy'])->name('admin.tahun-pelajaran.destroy');
        });
        Route::prefix('kurikulum')->group(function () {
            Route::get('/', [KurikulumController::class, 'index'])->name('admin.kurikulum.index');
            Route::get('/data', [KurikulumController::class, 'data'])->name('admin.kurikulum.data');
            Route::get('/add', [KurikulumController::class, 'add'])->name('admin.kurikulum.add');
            Route::post('/', [KurikulumController::class, 'store'])->name('admin.kurikulum.store');
            Route::get('/{kurikulum}/edit', [KurikulumController::class, 'edit'])->name('admin.kurikulum.edit');
            Route::put('/{kurikulum}/update', [KurikulumController::class, 'update'])->name('admin.kurikulum.update');
            Route::delete('/{kurikulum}/destroy', [KurikulumController::class, 'destroy'])->name('admin.kurikulum.destroy');
        });
        Route::prefix('jadwal')->group(function () {
            Route::get('/', [JadwalController::class, 'index'])->name('admin.jadwal.index');
            Route::get('/data', [JadwalController::class, 'data'])->name('admin.jadwal.data');

            Route::prefix('{kurikulumDetail}/{tahunPelajaran}/detail')->group(function () {
                Route::get('/', [JadwalDetailController::class, 'index'])->name('admin.jadwal.detail.index');
                Route::get('/data', [JadwalDetailController::class, 'data'])->name('admin.jadwal.detail.data');
                Route::get('/add', [JadwalDetailController::class, 'add'])->name('admin.jadwal.detail.add');
                Route::post('/', [JadwalDetailController::class, 'store'])->name('admin.jadwal.detail.store');
                Route::get('/{jadwal}/edit', [JadwalDetailController::class, 'edit'])->name('admin.jadwal.detail.edit');
                Route::put('/{jadwal}/update', [JadwalDetailController::class, 'update'])->name('admin.jadwal.detail.update');
                Route::delete('/{jadwal}/destroy', [JadwalDetailController::class, 'destroy'])->name('admin.jadwal.detail.destroy');

            });
        });
        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('admin.user.index');
            Route::get('/data', [UserController::class, 'data'])->name('admin.user.data');
            Route::get('/add', [UserController::class, 'add'])->name('admin.user.add');
            Route::post('/', [UserController::class, 'store'])->name('admin.user.store');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
            Route::put('/{user}/update', [UserController::class, 'update'])->name('admin.user.update');
            Route::delete('/{user}/destroy', [UserController::class, 'destroy'])->name('admin.user.destroy');
        });
        Route::prefix('role')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('admin.role.index');
            Route::get('/data', [RoleController::class, 'data'])->name('admin.role.data');
            Route::get('/add', [RoleController::class, 'add'])->name('admin.role.add');
            Route::post('/', [RoleController::class, 'store'])->name('admin.role.store');
            Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('admin.role.edit');
            Route::put('/{role}/update', [RoleController::class, 'update'])->name('admin.role.update');
            Route::delete('/{role}/destroy', [RoleController::class, 'destroy'])->name('admin.role.destroy');
        });
    });

    Route::middleware('role:admin,kepala sekolah')->group(function () {
        Route::prefix('dashboard')->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard.index');
        });
        Route::prefix('laporan-akademik')->group(function () {
            Route::get('/', [LaporanAkademikController::class, 'index'])->name('admin.laporan-akademik.index');
            Route::get('/laporanJadwal', [LaporanAkademikController::class, 'laporanJadwal'])->name('admin.laporan-akademik.laporanJadwal');
        });
        Route::prefix('cetak-laporan')->group(function () {
            Route::get('/', [CetakLaporanController::class, 'index'])->name('admin.cetak-laporan.index');
            Route::get('/data', [CetakLaporanController::class, 'data'])->name('admin.cetak-laporan.data');
            Route::get('/cetakNilai', [CetakLaporanController::class, 'cetakNilai'])->name('admin.cetak-laporan.cetakNilai');
            Route::get('/cetakAbsensi', [CetakLaporanController::class, 'cetakAbsensi'])->name('admin.cetak-laporan.cetakAbsensi');
        });
        Route::prefix('profile')->group(function () {
            Route::get('/', [ProfileController::class, 'index'])->name('admin.profile.index');
            Route::put('/', [ProfileController::class, 'update'])->name('admin.profile.update');
        });
    });

});
Route::prefix('guru')->middleware(['auth', 'role:guru'])->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [GuruDashboardController::class, 'index'])->name('guru.dashboard.index');
        Route::get('/edit', [GuruDashboardController::class, 'edit'])->name('guru.dashboard.edit');
        Route::put('/update', [GuruDashboardController::class, 'update'])->name('guru.dashboard.update');
    });

    Route::prefix('siswa')->group(function () {
        Route::get('/', [GuruSiswaController::class, 'index'])->name('guru.siswa.index');
        Route::get('/data', [GuruSiswaController::class, 'data'])->name('guru.siswa.data');
        Route::get('/{jadwal}/show', [GuruSiswaController::class, 'show'])->name('guru.siswa.show');
        Route::get('/{jadwal}/dataShow', [GuruSiswaController::class, 'dataShow'])->name('guru.siswa.dataShow');
    });

    Route::prefix('absensi')->group(function () {
        Route::get('/', [GuruAbsensiController::class, 'index'])->name('guru.absensi.index');
        Route::get('/data', [GuruAbsensiController::class, 'data'])->name('guru.absensi.data');

        Route::prefix('{jadwal}/rekap')->group(function () {
            Route::get('/', [GuruAbsensiRekapController::class, 'index'])->name('guru.absensi.rekap.index');
            Route::get('/data', [GuruAbsensiRekapController::class, 'data'])->name('guru.absensi.rekap.data');
            Route::get('/data-form', [GuruAbsensiRekapController::class, 'dataForm'])->name('guru.absensi.rekap.data-form');
            Route::get('/add', [GuruAbsensiRekapController::class, 'add'])->name('guru.absensi.rekap.add');
            Route::post('/', [GuruAbsensiRekapController::class, 'store'])->name('guru.absensi.rekap.store');
            Route::get('/{absensi}/edit', [GuruAbsensiRekapController::class, 'edit'])->name('guru.absensi.rekap.edit');
            Route::get('/{absensi}/data-form', [GuruAbsensiRekapController::class, 'dataFormEdit'])->name('guru.absensi.rekap.data-form-edit');
            Route::put('/{absensi}/update', [GuruAbsensiRekapController::class, 'update'])->name('guru.absensi.rekap.update');
            Route::delete('/{absensi}/destroy', [GuruAbsensiRekapController::class, 'destroy'])->name('guru.absensi.rekap.destroy');
        });
    });

    Route::prefix('nilai')->group(function () {
        Route::get('/', [GuruNilaiController::class, 'index'])->name('guru.nilai.index');
        Route::get('/data', [GuruNilaiController::class, 'data'])->name('guru.nilai.data');

        Route::prefix('{jadwal}')->group(function () {
            Route::prefix('bobot-nilai')->group(function () {
                Route::get('/', [GuruNilaiBobotController::class, 'index'])->name('guru.nilai.bobot-nilai.index');
                Route::post('/', [GuruNilaiBobotController::class, 'store'])->name('guru.nilai.bobot-nilai.store');
            });

            Route::prefix('input')->group(function () {
                Route::get('/', [GuruNilaiInputController::class, 'index'])->name('guru.nilai.input.index');
                Route::post('/', [GuruNilaiInputController::class, 'store'])->name('guru.nilai.input.store');
                Route::get('/data-form', [GuruNilaiInputController::class, 'dataForm'])->name('guru.nilai.input.data-form');
            });
        });
    });

    Route::prefix('profile')->group(function () {
        Route::get('/', [GuruProfileController::class, 'index'])->name('guru.profile.index');
        Route::put('/', [GuruProfileController::class, 'update'])->name('guru.profile.update');
    });
});
Route::prefix('siswa')->middleware(['auth', 'role:siswa'])->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [SiswaDashboardController::class, 'index'])->name('siswa.dashboard.index');
        Route::get('/edit', [SiswaDashboardController::class, 'edit'])->name('siswa.dashboard.edit');
        Route::put('/update', [SiswaDashboardController::class, 'update'])->name('siswa.dashboard.update');
    });

    Route::prefix('absensi/{kelasSub}')->group(function () {
        Route::get('/', [SiswaAbsensiController::class, 'index'])->name('siswa.absensi.index');
        Route::get('/data', [SiswaAbsensiController::class, 'data'])->name('siswa.absensi.data');
        Route::get('/{jadwal}/show', [SiswaAbsensiController::class, 'show'])->name('siswa.absensi.show');
    });

    Route::prefix('nilai/{kelasSub}')->group(function () {
        Route::get('/', [SiswaNilaiController::class, 'index'])->name('siswa.nilai.index');
        Route::get('/data', [SiswaNilaiController::class, 'data'])->name('siswa.nilai.data');
        Route::get('/{jadwal}/show', [SiswaNilaiController::class, 'show'])->name('siswa.nilai.show');
    });

    Route::prefix('profile')->group(function () {
        Route::get('/', [SiswaProfileController::class, 'index'])->name('siswa.profile.index');
        Route::put('/', [SiswaProfileController::class, 'update'])->name('siswa.profile.update');
    });
});
