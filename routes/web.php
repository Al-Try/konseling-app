<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

// ---------- Root ----------
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('guru.dashboard');
    }
    return redirect()->route('login');
});

// ---------- Auth ----------
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ---------------------- ADMIN ----------------------
Route::middleware(['auth','role:admin'])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
            ->name('dashboard');

        // Data Siswa — untuk saat ini hanya index (ubah kalau CRUD-nya sudah ada)
        Route::resource('siswa', \App\Http\Controllers\Admin\SiswaController::class)
    ->only(['index','create','store','edit','update','destroy']);

        // Import
        Route::get('siswa/import',  [\App\Http\Controllers\Admin\SiswaController::class, 'importForm'])
            ->name('siswa.import.form');
        Route::post('siswa/import', [\App\Http\Controllers\Admin\SiswaController::class, 'importStore'])
            ->name('siswa.import.store');
        Route::get('siswa/template', [\App\Http\Controllers\Admin\SiswaController::class, 'downloadTemplate'])
            ->name('siswa.template');
      
        // Jenis bimbingan
        Route::resource('jenis', \App\Http\Controllers\Admin\JenisBimbinganController::class)
            ->except(['show']);

        // Laporan PDF
        Route::get('/laporan/siswa/{siswa}', [\App\Http\Controllers\Admin\LaporanController::class,'rekapSiswa'])
            ->name('laporan.siswa');
        Route::get('/laporan/ranking-guru', [\App\Http\Controllers\Admin\LaporanController::class,'rankingGuru'])
            ->name('laporan.rankingGuru');
    });



// ---------------------- DASHBOARD (universal) ----------------------
Route::middleware('auth')->get('/dashboard', function () {
    $u = \Illuminate\Support\Facades\Auth::user();

    return match ($u->role ?? null) {
        'admin'     => redirect()->route('admin.dashboard'),
        'guru_wali' => redirect()->route('guru.dashboard'),
        default     => redirect()->route('login'),
    };
})->name('dashboard');



// (opsional) fallback, boleh dihapus sementara agar mudah debug
// Route::fallback(fn() => abort(404));
