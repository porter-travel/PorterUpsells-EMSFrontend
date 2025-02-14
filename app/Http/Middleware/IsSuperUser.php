<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsSuperUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //Check if the current logged in user has a role of super user
        if (auth()->user()->role !== 'superadmin') {
            return response()->json(['message' => 'You are not authorized to access this resource'], 403);
        }

        return $next($request);
    }
}
