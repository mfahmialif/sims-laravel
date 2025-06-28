<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check())
            return redirect('home');

        $user = Auth::user();
        $roleUser = $user->role->nama;
        foreach ($roles as $role) {
            if (strtolower($roleUser) == strtolower($role)) {
                return $next($request);
            }
        }
        return redirect()->route('home');
    }
}
