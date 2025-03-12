<?php

namespace App\Providers;

use Illuminate\Http\Request;
use App\Breadcrumbs\Breadcrumbs;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

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

        Request::macro('breadcrumbs', function (){
            return new Breadcrumbs($this);
        });

        // Register cookie-consent component
        Blade::component('cookie-consent', \App\View\Components\CookieConsent::class);

        DB::statement('SET NAMES utf8mb4');

        if (empty(config('app.key'))) {
            Config::set('app.key', 'base64:'.base64_encode(random_bytes(32)));
        }
    }
}
