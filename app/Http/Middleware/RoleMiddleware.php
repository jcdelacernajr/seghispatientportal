<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // User must be logged in
        if (!auth()->check()) {
            abort(403, 'Unauthorized');
        }

        // Support multiple roles: "admin, doctor, patient"
        $roleArray = explode(',', $role);

        foreach ($roleArray as $role) {
            if (auth()->user()->hasRole(trim($role))) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized');

        return $next($request);
    }
}
