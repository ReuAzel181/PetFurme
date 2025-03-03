<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PetOwnerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Only check if user is authenticated and is a pet owner
        if (!auth()->check() || !auth()->user()->isPetOwner()) {
            return redirect()->route('login')
                ->with('error', 'Please login to access your account.');
        }

        return $next($request);
    }
} 