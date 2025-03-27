<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class DatabaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Switch database connection based on environment
        if (app()->environment('production')) {
            Config::set('database.default', 'mysql_production');
        } elseif (app()->environment('local')) {
            Config::set('database.default', 'mysql');
        }
    }

    public function boot()
    {
        //
    }
} 