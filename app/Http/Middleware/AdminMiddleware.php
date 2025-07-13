<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            // Redirect to login page if not authenticated
            return redirect()->route('login')->with('error', 'Please login to access admin area.');
        }

        // Check if authenticated user has admin role
        $user = Auth::user();
        if (!$user || $user->role !== User::ROLE_ADMIN) {
            // If user is not admin, redirect with error message
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Access denied. Admin privileges required.'
                ], 403);
            }
            
            return redirect()->route('web.view.index')->with('error', 'Access denied. Admin privileges required.');
        }

        // Check if admin user is active
        if (!$user->is_active) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your account has been deactivated. Please contact support.');
        }

        return $next($request);
    }
}
