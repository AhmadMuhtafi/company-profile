<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
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
        Paginator::useBootstrapFive();

        View::composer(
            [
                'layouts.*',
                'partials.*',
                'home',
                'about',
                'services',
                'contact',
                'portfolio.*',
            ],
            function ($view) {
                $settings = cache()->remember(
                    'site_settings',
                    600,
                    fn () => Setting::pluck('value', 'key')->toArray()
                );

                $wa = preg_replace(
                    '/^0/',
                    '62',
                    preg_replace('/\D/', '', $settings['wa_number'] ?? '')
                );

                $view->with(compact('settings', 'wa'));
            }
        );
    }
}
