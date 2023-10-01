<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminPortal
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
        $sub_role = explode(",", $auth->sub_role);
        $sub_sub_role = explode(",", $auth->sub_sub_role);
        $ar_role = [
            "Admin System",
            "Super Admin",
            "Pegawai",
        ];
        if (in_array($role, $ar_role)) {
            if ($role == "Pegawai") {
                $ar_sub_role = [
                    "Admin Portal",
                    "Admin Aplikasi",
                ];
                if (count(array_intersect($sub_role, $ar_sub_role)) == 0) {
                    alert()->warning('Akses Ditolak!', 'Anda Tidak Memiliki Hak Akses!');
                    return redirect()->route('auth.home');
                }
                return $next($request);
            } else {
                return $next($request);
            }
        } else {
            alert()->warning('Akses Ditolak!', 'Anda Tidak Memiliki Hak Akses!');
            return redirect()->route('auth.home');
        }
    }
}
