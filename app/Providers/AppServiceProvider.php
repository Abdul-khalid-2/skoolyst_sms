<?php

namespace App\Providers;

use App\Models\School;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        View::composer('app.layouts.app', function ($view) {
            $invormentData = School::first();
            $view->with([
                'invormentdata' => $invormentData,
            ]);
        });
    }
}
