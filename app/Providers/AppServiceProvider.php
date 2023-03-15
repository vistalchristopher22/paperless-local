<?php

namespace App\Providers;

use App\Models\User;
use App\Enums\UserTypes;
use Laravel\Pennant\Feature;
use Illuminate\Database\Eloquent\Model;
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
        Model::preventLazyLoading(! app()->isProduction());
        Feature::purge();
        Feature::define('administrator', function (User $user) {
            return $user->account_type == UserTypes::ADMIN->value;
        });
    }
}
