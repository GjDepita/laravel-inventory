<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;  // ✅ Important: This must be here

class PreventRegistrationIfUsersExist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if there are any users in the database
        if (User::count() > 0) {
            abort(403, 'Registration is disabled.');
        }
        return $next($request);
    }

}
