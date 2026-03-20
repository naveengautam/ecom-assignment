<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // check if user is admin
        if(!auth()->check()) {
            return redirect('/login');
        }
        if(auth()->check() && !auth()->user()->isAdmin()) {
            return redirect('/')->with('error', 'You do not have admin access');
        }
        
        return $next($request);
    }
}
