<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CacheControl
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Cache static assets
        if ($request->is('fonts/*') || $request->is('images/*') || $request->is('favicon.ico')) {
            $response->header('Cache-Control', 'public, max-age=31536000');
            $response->header('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 31536000));
        }
        
        return $response;
    }
} 