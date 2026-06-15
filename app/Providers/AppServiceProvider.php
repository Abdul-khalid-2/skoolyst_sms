<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\User;
use App\Policies\ParentStudentPolicy;
use App\Services\Notice\NoticeNotificationService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.bootstrap-3');
        Paginator::defaultSimpleView('vendor.pagination.bootstrap-3');

        Gate::policy(User::class, ParentStudentPolicy::class);

        View::composer('app.layouts.app', function ($view) {
            $view->with([
                'invormentdata' => Setting::get(),
            ]);
        });

        View::composer('app.layouts.navigation', function ($view) {
            if (! Auth::check()) {
                $view->with([
                    'navNotifications' => collect(),
                    'navUnreadCount'   => 0,
                ]);

                return;
            }

            $user = Auth::user();
            $notifier = app(NoticeNotificationService::class);

            $view->with([
                'navNotifications' => $notifier->notificationsForUser($user, 6),
                'navUnreadCount'   => $notifier->unreadCountForUser($user),
            ]);
        });
    }
}
