<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Perusahaan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $auth = Auth::user();
        $role = $auth->role;
        $ar_role = [
            "Perusahaan",
        ];
        if (in_array($role, $ar_role)) {
            return $next($request);
        } else {
            return redirect()->route('auth.home');
        }
    }
}
