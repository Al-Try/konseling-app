<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Bimbingan;
use App\Policies\BimbinganPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Bimbingan::class => BimbinganPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
