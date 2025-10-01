<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}
    public function boot(): void
    {
        // opsional rate limiter
        // RateLimiter::for('api', fn($req) => [ Limit::perMinute(60)->by($req->user()?->id ?: $req->ip()) ]);
    }
}

