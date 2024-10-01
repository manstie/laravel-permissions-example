<?php

namespace App\Providers;

use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
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
        Passport::enablePasswordGrant();

        Gate::before(function ($user, $ability) {
            return $user->isAdmin() && $user->hasRole(Role::SUPER_ADMIN) ? true : null;
        });
    }
}
