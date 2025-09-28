<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\GuruWaliController;

Route::get('/', fn () => view('welcome'));

// Semua route berikut hanya untuk user yang sudah login
Route::middleware('auth')->group(function () {
    // Dashboard umum (opsional, kalau mau /dashboard tetap ada)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ===== ADMIN =====
    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::resource('siswa', SiswaController::class);
            Route::resource('kelas', KelasController::class);
            Route::resource('guru-wali', GuruWaliController::class);
        });

    // ===== GURU WALI =====
    Route::middleware('role:guru_wali')
        ->prefix('guru')
        ->name('guru.')
        ->group(function () {
            Route::get('/dashboard', fn () => view('dashboard.guru'))->name('dashboard');
            Route::resource('bimbingan', BimbinganController::class)->only(['index', 'create', 'store']);
        });
});
