<?php

namespace App\Providers;

use App\Models\User;
use App\Enums\UserTypes;
use App\Models\Committee;
use Laravel\Pennant\Feature;
use Illuminate\Pagination\Paginator;
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
        Paginator::useBootstrap();
        Model::preventAccessingMissingAttributes();
        Model::preventSilentlyDiscardingAttributes();
        Model::preventLazyLoading(!app()->isProduction());

        Feature::purge();

        Feature::define('administrator', function (User $user) {
            return $user->account_type == UserTypes::ADMIN->value;
        });

        Feature::define('user', function (User $user) {
            return $user->account_type == UserTypes::USER->value;
        });

        view()->composer(
            ['layouts.app'],
            function ($view) {
                $data = Committee::with(['lead_committee_information', 'lead_committee_information.chairman_information', 'submitted', 'submitted.division_information'])
                    ->whereNull('schedule_id')
                    ->get();
                $view->with('onReviewData', $data);
            }
        );
    }
}
