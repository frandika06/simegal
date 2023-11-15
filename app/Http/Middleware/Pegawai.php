<?php

namespace App\Http\Middleware;

use App\Helpers\CID;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Pegawai
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
            "Admin System",
            "Super Admin",
            "Kepala Dinas",
            "Kepala Bidang",
            "Pegawai",
        ];
        if (in_array($role, $ar_role)) {
            if ($role == "Pegawai") {
                $subRolePegawai = CID::subRolePegawai();
                if ($subRolePegawai == false) {
                    alert()->warning('Akses Ditolak!', 'Anda Tidak Memiliki Hak Akses!');
                    return \back();
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
