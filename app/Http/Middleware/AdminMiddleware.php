<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            $msg = $request->is('*hrms*') 
                ? 'Authentication Required: Please sign in as an Administrator to access the HRMS portal.' 
                : 'Please sign in to access the admin portal.';
            return redirect()->route('admin.login')->with('error', $msg);
        }

        if (Auth::user()->role !== 'admin') {
            Auth::logout();
            return redirect()->route('admin.login')->with('error', 'Unauthorized access: Admin privileges required.');
        }

        return $next($request);
    }
}

