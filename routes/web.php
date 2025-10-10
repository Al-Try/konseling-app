<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\KonselingController;
use App\Http\Controllers\Admin\JenisBimbinganController;
use App\Http\Controllers\Guru\BimbinganController; // kalau sudah ada



// Root: arahkan otomatis
Route::get('/', function () {
    if (Auth::check()) {
        return match (Auth::user()->role) {
            'admin'     => redirect()->route('admin.dashboard'),
            'guru_wali' => redirect()->route('guru.dashboard'),
            default     => redirect()->route('login'),
        };
    }
    return redirect()->route('login');
});

// Login / Logout
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ---------------------- ADMIN ----------------------
Route::middleware(['auth','role:admin'])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class,'index'])
            ->name('dashboard');

        Route::resource('siswa', \App\Http\Controllers\Admin\SiswaController::class);

        // ➜ Tambahkan ini
        Route::resource('konseling', \App\Http\Controllers\Admin\KonselingController::class)
            ->only(['index']);

        Route::resource('jenis', \App\Http\Controllers\Admin\JenisBimbinganController::class);

        Route::get('/laporan/siswa/{siswa}', [\App\Http\Controllers\Admin\LaporanController::class,'rekapSiswa'])
            ->name('laporan.siswa');
        Route::get('/laporan/ranking-guru', [\App\Http\Controllers\Admin\LaporanController::class,'rankingGuru'])
            ->name('laporan.rankingGuru');
    });


// ---------------------- GURU WALI ----------------------
Route::middleware(['auth','role:guru_wali'])
    ->prefix('guru')->name('guru.')
    ->group(function () {
        // ⬇️ Minimal ada 1 dashboard juga supaya redirect role guru aman
        Route::get('/dashboard', fn () => view('guru_wali.dashboard'))->name('dashboard');

        Route::get('/bimbingan/siswa/search', [\App\Http\Controllers\Guru\BimbinganController::class,'siswaSearch'])
            ->name('bimbingan.siswa.search');
        Route::resource('bimbingan', \App\Http\Controllers\Guru\BimbinganController::class)
            ->only(['index','create','store','show']);
    });


// ---------------------- DEV-ONLY (opsional) ----------------------
if (app()->environment('local')) {
    Route::get('/dev/as-admin', fn () => tap(Auth::loginUsingId(1), fn() => request()->session()->regenerate()) ? redirect()->route('admin.dashboard') : abort(403));
    Route::get('/dev/as-guru',  fn () => tap(Auth::loginUsingId(2), fn() => request()->session()->regenerate()) ? redirect()->route('guru.dashboard')  : abort(403));
}

// ---------------------- DASHBOARD ----------------------
Route::middleware('auth')->get('/dashboard', function () {
    $u = Auth::user();

    return match ($u->role ?? null) {
        'admin'     => redirect()->route('admin.dashboard'),
        'guru_wali' => redirect()->route('guru.dashboard'),
        default     => redirect()->route('login'),
    };
})->name('dashboard');

Route::fallback(function () {
    abort(404);
});
