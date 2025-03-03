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
        }
    }

    public function boot()
    {
        //
    }
} 