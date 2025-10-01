<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\Bimbingan::class => \App\Policies\BimbinganPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // contoh tambahan: Gate
        // Gate::define('manage-bimbingan', fn($user, $bimbingan) => $user->id === $bimbingan->guru_wali_id);
    }
}
