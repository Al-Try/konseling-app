<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    
    protected $policies = [
        \App\Models\Bimbingan::class => \App\Policies\BimbinganPolicy::class,
    ];
    public function boot(): void { $this->registerPolicies(); }


}
