<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ResponseCache
{
    public function handle(Request $request, Closure $next)
    {
        // Quick check for methods that should never be cached
        if (!$request->isMethod('GET')) {
            return $next($request);
        }

        // Generate cache key early
        $cacheKey = $this->generateCacheKey($request);

        // Check cache first
        if (Cache::has($cacheKey)) {
            return response(Cache::get($cacheKey))
                ->header('X-Cache', 'HIT');
        }

        $response = $next($request);

        // Only cache successful responses
        if ($response->isSuccessful() && !$this->shouldSkipCache($request)) {
            Cache::put($cacheKey, $response->getContent(), now()->addMinutes(5));
        }

        return $response;
    }

    protected function shouldSkipCache(Request $request): bool
    {
        return $request->ajax() 
            || $request->hasHeader('Authorization')
            || $request->cookie('cookie_consent') !== 'accepted'
            || in_array($request->path(), [
                'login',
                'register',
                'logout',
                'password/reset',
            ]);
    }

    protected function shouldCache(Request $request, $response): bool
    {
        return !$request->ajax() 
            && $response->getStatusCode() === 200
            && $response instanceof Response
            && !$response->headers->has('Location');
    }

    protected function generateCacheKey(Request $request): string
    {
        $userId = auth()->id() ?? 'guest';
        $path = $request->path();
        $query = $request->getQueryString() ?? '';
        
        return sprintf(
            'response_cache:%s:%s:%s',
            $userId,
            $path,
            md5($query)
        );
    }
} 