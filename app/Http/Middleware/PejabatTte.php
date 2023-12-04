<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PejabatTte
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('api/*')) {
            // pengguna mengakses route API
            $auth = auth()->user();
        } else {
            $auth = Auth::user();
        }

        $role = $auth->role;
        $sub_role = \explode(',', $auth->sub_role);
        $sub_sub_role = \explode(',', $auth->sub_sub_role);
        if ($role == "Kepala Dinas" || $role == "Kepala Bidang") {
            // izinkan
            return $next($request);
        } elseif ($role == "Pegawai") {
            // PEGAWAI
            $ar_sub_role = ['Ketua Tim'];
            if (count(array_intersect($sub_role, $ar_sub_role)) != 0) {
                // izinkan
                return $next($request);
            } else {
                // blokir
                return $this->blockResponse($request, 1);
            }
        } else {
            // blokir
            return $this->blockResponse($request, 1);
        }
    }

    // function block api
    private function blockResponse($request, $style = null)
    {
        if ($request->is('api/*')) {
            return $this->blockApi();
        } else {
            if ($style == "1") {
                return $this->blockWebHome();
            } elseif ($style == "2") {
                return $this->blockWebBack();
            }
        }
    }
    // function block api
    private function blockApi()
    {
        $response = [
            "status" => false,
            "message" => "You Can't Access This Route!",
        ];
        return response()->json($response, 422);
    }
    // function block web to home
    private function blockWebHome()
    {
        alert()->warning('Akses Ditolak!', 'Anda Tidak Memiliki Hak Akses!');
        return redirect()->route('auth.home');
    }
    // function block web to back
    private function blockWebBack()
    {
        alert()->warning('Akses Ditolak!', 'Anda Tidak Memiliki Hak Akses!');
        return \back();
    }
}
