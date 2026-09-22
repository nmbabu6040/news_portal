<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
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
     *
     * NOTE: If your fresh Laravel install already has an AppServiceProvider,
     * just copy the boot() method body below into it instead of overwriting
     * the whole file (register() usually stays empty).
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        View::composer('layouts.site', function ($view) {
            $view->with(
                'tickerHeadlines',
                Article::published()->latest('published_at')->take(6)->pluck('title', 'slug')
            );

            // ডায়নামিক ক্যাটাগরি পাঠানো হচ্ছে (যেমন: ৮টি ক্যাটাগরি)
            $view->with(
                'footerCategories',
                Category::take(8)->get() // আপনার মডেলের পছন্দমত কোয়েরি দিতে পারেন
            );

            $view->with('settings', Setting::current());
        });

        // Breeze-এর লগইন/রেজিস্টার পেজ ও ড্যাশবোর্ড নেভবারেও সাইটের সেটিংস দরকার
        View::composer(['layouts.guest', 'layouts.navigation'], function ($view) {
            $view->with('settings', Setting::current());
        });

        View::composer('*', function ($view) {
            $view->with('setting', Setting::first());
        });
    }
}
