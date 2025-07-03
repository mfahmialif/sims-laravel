<?php
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\KelasSiswaController;
use App\Http\Controllers\Admin\KelasSubController;
use App\Http\Controllers\Admin\KelasWaliController;
use App\Http\Controllers\Admin\KepalaSekolahController;
use App\Http\Controllers\Admin\PendaftaranSiswaBaruController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard.index');
    });
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
        Route::get('/{siswa}/edit', [SiswaController::class, 'edit'])->name('admin.siswa.edit');
        Route::put('/{siswa}/update', [SiswaController::class, 'update'])->name('admin.siswa.update');
        Route::delete('/{siswa}/destroy', [SiswaController::class, 'destroy'])->name('admin.siswa.destroy');
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
