<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class Logger
{
    public static function log($message)
    {
        Log::info($message);
    }
} 