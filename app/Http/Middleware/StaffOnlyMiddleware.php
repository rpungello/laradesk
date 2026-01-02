<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StaffOnlyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user()->isStaff()) {
            abort(403);
        }

        return $next($request);
    }
}
