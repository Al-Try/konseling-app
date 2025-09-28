<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// (Opsional) import ini hanya jika kamu ingin set rate limiter di sini
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // JANGAN panggil $this->configureRateLimiting();
        // JANGAN daftarkan routes di sini (sudah di bootstrap/app.php)

        // (OPSIONAL) contoh rate limit untuk group 'api'
        // Hapus blok ini kalau tidak dibutuhkan.
        RateLimiter::for('api', function (Request $request) {
            return [
                Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip()),
            ];
        });
    }
}
