<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $roles)
    {
        if (!Auth::check()) return redirect()->route('login');
        $allowed = explode('|', $roles); // role:admin|guru_wali
        if (!in_array(Auth::user()->role, $allowed, true)) abort(403, 'Forbidden');
        return $next($request);
    }
}
