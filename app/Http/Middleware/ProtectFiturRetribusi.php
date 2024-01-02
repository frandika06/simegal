<?php

namespace App\Http\Middleware;

use App\Helpers\CID;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProtectFiturRetribusi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $statusRetribusi = CID::getMasterFitur("Retribusi")->status;
        if ($statusRetribusi == "0") {
            // blokir
            return $this->blockResponse($request, 1);
        }
        return $next($request);
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
        alert()->warning('Akses Ditolak!', 'Fitur Retribusi Telah Di Non-Aktifkan!');
        return redirect()->route('auth.home');
    }
    // function block web to back
    private function blockWebBack()
    {
        alert()->warning('Akses Ditolak!', 'Fitur Retribusi Telah Di Non-Aktifkan!');
        return \back();
    }
}
