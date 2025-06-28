<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard.index');
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
