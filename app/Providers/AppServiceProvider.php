<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SystemInfo;

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
    public function boot()
    {
        // Share footer data with all views that include the footer
        View::composer('frontend.include.footer', function ($view) {
            $footer = SystemInfo::first();
            $view->with('footer', $footer);
        });
    }
}
