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
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('siswa', SiswaController::class);

        Route::resource('konseling', KonselingController::class)
            ->only(['index']); // tambah create/store/show kalau siap

        Route::resource('jenis', JenisBimbinganController::class)
            ->parameters(['jenis' => 'jenis'])
            ->names('jenis')
            ->only(['index']); // nanti tambah store/update/destroy
    });


// ---------------------- GURU WALI ----------------------
// ---------------------- GURU WALI ----------------------
Route::middleware(['auth','role:guru_wali'])
    ->prefix('guru')->name('guru.')
    ->group(function () {
        Route::get('/dashboard', fn() => view('dashboard.guru'))->name('dashboard');

        // kalau sudah bikin controller
        // Route::resource('bimbingan', BimbinganController::class)->only(['index','create','store','show']);
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