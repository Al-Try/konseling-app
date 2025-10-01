<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\KonselingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
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
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('siswa', \App\Http\Controllers\Admin\SiswaController::class);

        // pastikan ini ada kalau dipakai di menu
        Route::resource('konseling', \App\Http\Controllers\Admin\KonselingController::class)
            ->only(['index']); // tambahkan create/store/show bila siap

        Route::resource('jenis', \App\Http\Controllers\Admin\JenisBimbinganController::class)
            ->parameters(['jenis' => 'jenis'])
            ->names('jenis')    // menghasilkan admin.jenis.index, dst
            ->only(['index']);  // tambah create/store bila siap
    });



// ---------------------- GURU WALI ----------------------
Route::middleware(['auth','role:guru_wali'])
    ->prefix('guru')->name('guru.')
    ->group(function () {
        Route::get('/dashboard', fn() => view('dashboard.guru'))->name('dashboard');
        // … (routes bimbingan)
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