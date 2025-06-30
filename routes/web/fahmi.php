<?php
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PendaftaranSiswaBaruController;
use App\Http\Controllers\Admin\RoleController;
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
        Route::get('/{siswa}/edit', [PendaftaranSiswaBaruController::class, 'edit'])->name('admin.pendaftaran-siswa-baru.edit');
        Route::put('/{siswa}/update', [PendaftaranSiswaBaruController::class, 'update'])->name('admin.pendaftaran-siswa-baru.update');
        Route::delete('/{siswa}/destroy', [PendaftaranSiswaBaruController::class, 'destroy'])->name('admin.pendaftaran-siswa-baru.destroy');
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
