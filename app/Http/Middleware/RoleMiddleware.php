<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //  if(Auth::user()->role !='admin'){
    //     return redirect('dashboard');
    //  }
    
    //     return $next($request);
    // }
    public function handle($request, Closure $next, ...$roles)
{
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    if (!in_array(auth()->user()->role, $roles)) {
        // abort(403, 'Accès non autorisé.');
        return redirect()->route('dashboard');
    }

    return $next($request);
}

}
