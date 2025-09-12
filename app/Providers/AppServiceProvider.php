<?php

namespace App\Providers;

use App\Enum\AppPermission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Gate::before(fn($user, $ability) => ($user->is_super_admin ?? false) ? true : null);

        foreach (AppPermission::cases() as $perm) {
            Gate::define($perm->value, fn($user) => $user->hasPermission($perm));
        }
    }
}
