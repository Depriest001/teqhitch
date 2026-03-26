<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use App\Models\SystemInfo;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrapFive();
        $setting = SystemInfo::first(); // or however you fetch it            
        View::share('globalSetting', $setting);
    }
    // public function boot()
    // {
    //     $setting = SystemInfo::first(); // or however you fetch it            
    //     View::share('globalSetting', $setting);
    //     URL::forceScheme('https');
    // }
}
