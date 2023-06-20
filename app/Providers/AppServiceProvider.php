<?php

namespace App\Providers;

use App\Models\User;
use App\Enums\UserTypes;
use Laravel\Pennant\Feature;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use App\ViewComposers\CommitteeViewComposer;
use App\ViewComposers\NotificationViewComposer;

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
        Paginator::useBootstrap();

        View::composer(['layouts.app', 'layouts.app-2'], CommitteeViewComposer::class);
        View::composer(['layouts.app', 'layouts.app-2'], NotificationViewComposer::class);

        Model::preventAccessingMissingAttributes();
        Model::preventSilentlyDiscardingAttributes();
        Model::preventLazyLoading(!app()->isProduction());


        Feature::define('administrator', function (User $user) {
            return $user->account_type == UserTypes::ADMIN->value;
        });

        Feature::define('user', function (User $user) {
            return $user->account_type == UserTypes::USER->value;
        });

        Feature::define('sb-member', function (User $user) {
            return $user->account_type == UserTypes::SP_MEMBER->value;
        });
    }
}
