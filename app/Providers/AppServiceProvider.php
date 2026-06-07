<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\User;
use App\Policies\ParentStudentPolicy;
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
    }
}
