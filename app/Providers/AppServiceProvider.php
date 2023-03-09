<?php

namespace App\Providers;

use App\Enums\UserTypes;
use App\Models\User;
use Laravel\Pennant\Feature;
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
        Feature::define('administrator', function (User $user) {
            return $user->account_type == UserTypes::ADMIN->name;
        });
    }
}
