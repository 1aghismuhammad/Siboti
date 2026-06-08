<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class CheckCustomMaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        // If the maintenance file exists, the system is in maintenance mode
        if (Storage::disk('local')->exists('maintenance_mode.txt')) {
            // Allow admin to bypass maintenance mode
            if (auth()->check() && auth()->user()->role === 'admin') {
                return $next($request);
            }
            
            // Allow login, logout, and admin routes so admin can authenticate
            if ($request->is('login') || $request->is('logout') || $request->is('admin*')) {
                return $next($request);
            }

            // Return custom maintenance view with 503 status
            return response()->view('maintenance', [], 503);
        }

        return $next($request);
    }
}
