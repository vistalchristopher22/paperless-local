<?php

namespace App\Providers;

use App\Contracts\ScreenDisplayRepositoryInterface;
use App\Enums\UserTypes;
use App\Models\User;
use App\Repositories\ScreenDisplayRepository;
use App\Repositories\SettingRepository;
use App\Utilities\FileUtility;
use App\ViewComposers\CommitteeViewComposer;
use App\ViewComposers\NotificationViewComposer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Pennant\Feature;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ScreenDisplayRepositoryInterface::class, ScreenDisplayRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        View::composer(['layouts.app', 'layouts.app-2'], CommitteeViewComposer::class);
        View::composer(['layouts.app', 'layouts.app-2'], NotificationViewComposer::class);
        View::composer(['layouts.app', 'layouts.app-2', 'admin.board-sessions.display', 'admin.committee.file-displays', 'admin.screen.index', 'admin.scree.screen-session', 'admin.screen.screen-question-of-hour', 'admin.screen.screen-privilege-hour', 'admin.screen.screen-order-of-business', 'admin.screen.screen-table'], function ($view) {
            $view->with('serverSocketUrl', "http://localhost:3030");
            $view->with('localSocketUrl', "http://localhost:3030");
        });

        View::composer(['layouts.app', 'layouts.app-2'], function ($view) {
            $view->with('networkFolder', SettingRepository::getValueByName('network_source_folder'));
            $view->with('sourceFolder', FileUtility::correctDirectorySeparator(SettingRepository::getValueByName('source_folder') ?? ''));
            $view->with('isServer', request()->ip() == config('app.server_ip'));
        });

        Model::preventAccessingMissingAttributes();
        Model::preventSilentlyDiscardingAttributes();
        // Model::preventLazyLoading(!app()->isProduction());

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
