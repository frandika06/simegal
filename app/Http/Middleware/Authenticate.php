<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->is('api/*')) {
            // pengguna mengakses route API
            return $request->expectsJson() ? null : route('api.lgn.index');
        } else {
            // pengguna mengakses route web
            return $request->expectsJson() ? null : route('api.lgn.index');
        }
    }
}
