<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controllers (pakai yang sudah ada di project kamu)
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\GuruWaliController;
use App\Http\Controllers\BimbinganController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'));

Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED – GENERIC DASHBOARD REDIRECTOR
| (optional helper: saat user masuk /dashboard diarahkan sesuai role)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->get('/dashboard', function () {
    $user = Auth::user();
    if (! $user) return redirect()->route('login');

    return match ($user->role) {
        'admin'      => redirect()->route('admin.dashboard'),
        'guru_wali'  => redirect()->route('guru.dashboard'),
        default      => view('dashboard.index'), // fallback kalau ada
    };
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
| Pastikan alias middleware 'role' sudah ada di bootstrap/app.php:
| $middleware->alias(['role' => \App\Http\Middleware\RoleMiddleware::class]);
*/
Route::middleware(['auth','role:admin'])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        // Dashboard admin (gunakan DashboardController yang sudah ada)
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Master data
        Route::resource('siswa', SiswaController::class);
        Route::resource('kelas', KelasController::class);
        Route::resource('guru-wali', GuruWaliController::class);

        // Data bimbingan (admin biasanya melihat/monitor)
        Route::resource('bimbingan', BimbinganController::class)->only(['index','show']);
    });
    Route::resource('jenis-bimbingan', \App\Http\Controllers\Admin\JenisBimbinganController::class)
    ->parameters(['jenis-bimbingan' => 'jenis'])
    ->names('jenis');

    Route::get('/laporan/siswa/{siswa}', [\App\Http\Controllers\Admin\LaporanController::class,'siswa'])
    ->name('laporan.siswa');

    Route::get('/laporan/ranking-guru', [\App\Http\Controllers\Admin\LaporanController::class,'ranking'])
    ->name('laporan.ranking-guru');


/*
|--------------------------------------------------------------------------
| GURU WALI ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:guru_wali'])
    ->prefix('guru')->name('guru.')
    ->group(function () {
        // Dashboard guru wali – kamu sudah punya view 'dashboard.guru' atau bisa pakai controller sendiri
        Route::get('/dashboard', fn () => view('dashboard.guru'))->name('dashboard');

        // Aktivitas bimbingan oleh guru wali
        Route::resource('bimbingan', BimbinganController::class)
            ->only(['index','create','store','show']); // sesuaikan jika perlu edit/update/delete
    });

    Route::get('/bimbingan/siswa/search', [\App\Http\Controllers\Guru\BimbinganController::class,'siswaSearch'])
    ->name('bimbingan.siswa.search');

Route::resource('bimbingan', \App\Http\Controllers\Guru\BimbinganController::class)
    ->only(['index','create','store','show']);

/*
|--------------------------------------------------------------------------
| DEV-ONLY ROUTES (TIDAK AKTIF DI PRODUCTION)
| Mempermudah preview UI & impersonate user saat pengembangan.
|--------------------------------------------------------------------------
*/
if (app()->environment('local')) {

    // Impersonate cepat (ganti ID sesuai data kamu)
    Route::get('/dev/as-admin', function () {
        Auth::loginUsingId(1);  // id user admin
        request()->session()->regenerate();
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dev/as-guru', function () {
        Auth::loginUsingId(2);  // id user guru wali
        request()->session()->regenerate();
        return redirect()->route('guru.dashboard');
    });

    Route::get('/dev/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return 'Logged out (DEV)';
    });

    // Preview UI tanpa auth (kalau butuh)
    Route::get('/dev/admin/dashboard', [DashboardController::class, 'index'])
        ->withoutMiddleware(['auth','role:admin']);

    Route::view('/dev/guru/dashboard', 'guru_wali.index'); // sesuaikan view
}

/*
|--------------------------------------------------------------------------
| FALLBACK 404
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
