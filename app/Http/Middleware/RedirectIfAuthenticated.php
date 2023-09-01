<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if ($request->is('api/*')) {
                    // pengguna mengakses route API
                    $response = [
                        "status" => false,
                        "message" => "Guest Route!",
                    ];
                    return response()->json($response, 422);
                    // return redirect(RouteServiceProvider::API);
                } else {
                    // pengguna mengakses route web
                    return redirect(RouteServiceProvider::HOME);
                }
            }
        }

        return $next($request);
    }
}