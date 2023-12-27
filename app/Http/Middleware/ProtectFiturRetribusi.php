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
            alert()->warning('Akses Ditolak!', 'Fitur Retribusi Telah di Non-Aktifkan!');
            return redirect()->route('pdp.apps.home.index');
        }
        return $next($request);
    }
}
