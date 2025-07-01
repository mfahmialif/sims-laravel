<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PendaftaranSiswaBaruController;

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
