<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use App\Models\SystemInfo;
use App\Models\Course;
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

        $courses = Course::where('status', 'published')
            ->inRandomOrder()
            ->limit(5)
            ->get();

        View::share('globalSetting', $setting);
        View::share('globalcourses', $courses);
    }
}
