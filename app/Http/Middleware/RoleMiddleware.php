<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
         if(Auth::check()){
            $userRole = Auth::user()->role;

            // Admin can do everything
            if ($userRole === 'admin') {
                return $next($request);
            }

            // Viewer can view everything (only GET requests)
            if ($userRole === 'viewer' && $request->isMethod('get')) {
                return $next($request);
            }

            // Normal role check
            if ($userRole === $role) {
                return $next($request);
            }
        }
        abort(403, 'You do not have permission to access this page.');
    }
}
