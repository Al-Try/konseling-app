<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        // Kalau belum login → lempar ke login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Kalau role user tidak sama → tolak akses
        if (Auth::user()->role !== $role) {
            abort(403, 'Unauthorized action.');
        }

        // Lolos → lanjut ke request berikutnya
        return $next($request);
    }
}
