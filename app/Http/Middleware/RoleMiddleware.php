<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = auth()->user();

        if (!$user) {
            abort(403, 'Unauthorized.');
        }

        if ($role === 'user') {
            if ($user->role === 'user' || $user->role === 'super_admin') {
                return $next($request);
            }
        }

        if ($role === 'admin' && $user->role === 'admin') {
            return $next($request);
        }

        abort(403, 'Unauthorized.');
    }
}
