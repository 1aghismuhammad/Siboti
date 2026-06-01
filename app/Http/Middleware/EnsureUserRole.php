<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403, 'Unauthorized action.');
        }

        $allowedRoles = array_filter(
            array_map('trim', preg_split('/[\,|]/', $roles))
        );

        if (! $user->hasAnyRole($allowedRoles)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
