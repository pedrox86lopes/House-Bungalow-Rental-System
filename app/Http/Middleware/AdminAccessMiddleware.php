<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect('/login'); // Redirect to login if not authenticated
        }

        // Get the authenticated user's email
        $userEmail = Auth::user()->email;

        // Get the admin email from the .env file
        $adminEmail = env('ADMIN_EMAIL');

        // Check if the user's email matches the admin email
        if ($userEmail === $adminEmail) {
            return $next($request); // Allow access
        }

        // If not the admin, redirect or abort
        abort(403, 'Unauthorized access.'); // Or redirect to a different page, e.g., return redirect('/dashboard');
    }
}
