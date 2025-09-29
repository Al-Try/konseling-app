<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
// === DEV ONLY: bypass login ===
if (app()->environment('local')) {

    // login sebagai ADMIN (asumsikan user id=1 adalah admin)
    Route::get('/dev/as-admin', function () {
        Auth::loginUsingId(1);           // ganti 1 dengan id admin di tabel users
        request()->session()->regenerate();
        return redirect('/admin/dashboard');
    });

    // login sebagai GURU WALI (asumsikan user id=2 adalah guru wali)
    Route::get('/dev/as-guru', function () {
        Auth::loginUsingId(2);           // ganti 2 dengan id guru wali
        request()->session()->regenerate();
        return redirect('/guru/dashboard');
    });

    // logout cepat
    Route::get('/dev/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return 'Logged out (DEV)';
    });
}
if (app()->environment('local')) {

    Route::get('/dev/admin/dashboard', [DashboardController::class, 'index'])
        ->withoutMiddleware(['auth', 'role:admin']);

    // kalau mau: guru dashboard UI langsung
    Route::view('/dev/guru/dashboard', 'guru_wali.index');
}
