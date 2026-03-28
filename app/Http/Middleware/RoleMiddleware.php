<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Usage in routes: ->middleware('role:admin,manager')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Must be authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRole = auth()->user()->role;

        // Check if user's role is in the allowed roles list
        if (!in_array($userRole, $roles)) {
            // Redirect unauthorised users back to their own dashboard
            abort(403, 'Unauthorized. You do not have permission to access this page.');
        }

        return $next($request);
    }
}