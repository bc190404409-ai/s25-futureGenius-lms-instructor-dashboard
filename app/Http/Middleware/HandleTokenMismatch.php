<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;

class HandleTokenMismatch
{
    /**
     * Handle an incoming request and catch token mismatch exceptions.
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            return $next($request);
        } catch (TokenMismatchException $e) {
            // Redirect to login with a friendly message
            return redirect()->route('login.form')->with('error', 'Session expired. Please try again.');
        }
    }
}
