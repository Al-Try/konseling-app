<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// ---------------------- PUBLIC ----------------------
Route::get('/', fn() => view('welcome'));
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// /dashboard -> redirect sesuai role (aman kalau mau dipakai)
Route::middleware('auth')->get('/dashboard', function () {
    $u = Auth::user();
    return match ($u->role ?? null) {
        'admin'     => redirect()->route('admin.dashboard'),
        'guru_wali' => redirect()->route('guru.dashboard'),
        default     => view('dashboard.index'),
    };
})->name('dashboard');

// ---------------------- ADMIN ----------------------
Route::middleware(['auth','role:admin'])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('siswa', \App\Http\Controllers\Admin\SiswaController::class);
        Route::resource('kelas', \App\Http\Controllers\Admin\KelasController::class);
        Route::resource('guru-wali', \App\Http\Controllers\Admin\GuruWaliController::class);

        // Jenis Bimbingan (kategori + poin)
        Route::resource('jenis-bimbingan', \App\Http\Controllers\Admin\JenisBimbinganController::class)
            ->parameters(['jenis-bimbingan' => 'jenis'])
            ->names('jenis');

        // Laporan PDF
        Route::get('/laporan/siswa/{siswa}', [\App\Http\Controllers\Admin\LaporanController::class,'rekapSiswa'])
            ->name('laporan.siswa');
        Route::get('/laporan/ranking-guru', [\App\Http\Controllers\Admin\LaporanController::class,'rankingGuru'])
            ->name('laporan.rankingGuru');
    });

// ---------------------- GURU WALI ----------------------
Route::middleware(['auth','role:guru_wali'])
    ->prefix('guru')->name('guru.')
    ->group(function () {
        Route::get('/dashboard', fn() => view('dashboard.guru'))->name('dashboard');

        Route::get('/bimbingan/siswa/search', [\App\Http\Controllers\Guru\BimbinganController::class,'siswaSearch'])
            ->name('bimbingan.siswa.search');

        Route::resource('bimbingan', \App\Http\Controllers\Guru\BimbinganController::class)
            ->only(['index','create','store','show']);
    });

// ---------------------- DEV-ONLY ----------------------
if (app()->environment('local')) {
    Route::get('/dev/as-admin', function () {
        Auth::loginUsingId(1); request()->session()->regenerate();
        return redirect()->route('admin.dashboard');
    });
    Route::get('/dev/as-guru', function () {
        Auth::loginUsingId(2); request()->session()->regenerate();
        return redirect()->route('guru.dashboard');
    });
    Route::get('/dev/logout', function () {
        Auth::logout(); request()->session()->invalidate(); request()->session()->regenerateToken();
        return 'Logged out (DEV)';
    });

    // preview UI tanpa auth jika perlu:
    Route::get('/dev/admin/dashboard', [DashboardController::class, 'index'])
        ->withoutMiddleware(['auth','role:admin']);
}

Route::fallback(fn() => response()->view('errors.404', [], 404));
