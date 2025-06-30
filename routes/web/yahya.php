<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KelasController;

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