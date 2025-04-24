<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register policies.
     */
    protected function registerPolicies(): void
    {
        // Register any authentication / authorization policies here.
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        

        Gate::define('is-hr', function ($user) {
            return $user->role === 'hr';
        });
    
        Gate::define('is-employee', function ($user) {
            return $user->role === 'employee';
        });
    }
}
