<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class EnsureEmailIsVerified
{
    public function handle($request, Closure $next)
    {
        if (! $request->user() ||
            ($request->user() && ! $request->user()->hasVerifiedEmail())) {
            return response()->json([
                'success' => false,
                'message' => 'Your email address is not verified.',
                'verification_required' => true
            ], 403);
        }

        return $next($request);
    }
} 