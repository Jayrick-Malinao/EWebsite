<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $allowedRoles = [];

        foreach ($roles as $role) {
            $allowedRoles = array_merge(
                $allowedRoles,
                explode('|', $role)
            );
        }

        $allowedRoles = array_map('trim', $allowedRoles);

        if (! in_array($request->user()->role, $allowedRoles, true)) {
            abort(403, 'You are not authorized to access this page.');
        }

        return $next($request);
    }
}