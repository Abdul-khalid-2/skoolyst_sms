<?php

namespace App\Providers;

use App\Models\AppNotification;
use App\Models\Setting;
use App\Models\User;
use App\Policies\ParentStudentPolicy;
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

            $userId = Auth::id();

            $view->with([
                'navNotifications' => AppNotification::where('user_id', $userId)
                    ->orderByDesc('created_at')
                    ->limit(6)
                    ->get(),
                'navUnreadCount' => AppNotification::where('user_id', $userId)->unread()->count(),
            ]);
        });
    }
}
