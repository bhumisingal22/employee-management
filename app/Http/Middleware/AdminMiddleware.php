<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
         // Check if the user is authenticated and if they are an admin
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect('/'); 
        }

        return $next($request);
    }
}
