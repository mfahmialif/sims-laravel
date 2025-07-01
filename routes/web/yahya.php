<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\KurikulumController;
use App\Http\Controllers\Admin\MataPelajaranController;
use App\Http\Controllers\Admin\TahunPelajaranController;

// ketik di sini, contoh file fahmi.php
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard.index');
    });
    Route::prefix('kelas')->group(function () {
        Route::get('/', [KelasController::class, 'index'])->name('admin.kelas.index');
        Route::get('/data', [KelasController::class, 'data'])->name('admin.kelas.data');
        Route::get('/add', [KelasController::class, 'add'])->name('admin.kelas.add');
        Route::post('/', [KelasController::class, 'store'])->name('admin.kelas.store');
        Route::get('/{kelas}/edit', [KelasController::class, 'edit'])->name('admin.kelas.edit');
        Route::put('/{kelas}/update', [KelasController::class, 'update'])->name('admin.kelas.update');
        Route::delete('/{kelas}/destroy', [KelasController::class, 'destroy'])->name('admin.kelas.destroy');
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
    // Route::prefix('user')->group(function () {
    //     Route::get('/', [UserController::class, 'index'])->name('admin.user.index');
    //     Route::get('/data', [UserController::class, 'data'])->name('admin.user.data');
    //     Route::get('/add', [UserController::class, 'add'])->name('admin.user.add');
    //     Route::post('/', [UserController::class, 'store'])->name('admin.user.store');
    //     Route::get('/{user}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
    //     Route::put('/{user}/update', [UserController::class, 'update'])->name('admin.user.update');
    //     Route::delete('/{user}/destroy', [UserController::class, 'destroy'])->name('admin.user.destroy');
    // });
    // Route::prefix('role')->group(function () {
    //     Route::get('/', [RoleController::class, 'index'])->name('admin.role.index');
    //     Route::get('/data', [RoleController::class, 'data'])->name('admin.role.data');
    //     Route::get('/add', [RoleController::class, 'add'])->name('admin.role.add');
    //     Route::post('/', [RoleController::class, 'store'])->name('admin.role.store');
    //     Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('admin.role.edit');
    //     Route::put('/{role}/update', [RoleController::class, 'update'])->name('admin.role.update');
    //     Route::delete('/{role}/destroy', [RoleController::class, 'destroy'])->name('admin.role.destroy');
    // });
});