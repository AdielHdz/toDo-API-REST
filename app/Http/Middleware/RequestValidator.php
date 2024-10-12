<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RequestValidator
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->bearerToken() && $request->is('api/user')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
