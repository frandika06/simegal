<?php

namespace App\Http\Middleware;

use App\Models\AppsCounter;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class MobileFECounter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // cek counter
        $tgl = \date('Y-m-d');
        $data = AppsCounter::whereDevice("mobile")->whereDate("tanggal", $tgl)->first();
        if ($data === null) {
            $value = [
                "uuid" => Str::uuid(),
                "nama_apps" => "Portal Apps",
                "visual_template" => "FE",
                "views" => "1",
                "device" => "mobile",
                "tanggal" => $tgl,
            ];
            AppsCounter::create($value);
        } else {
            $views = $data->views + 1;
            $data->update(["views" => $views]);
        }
        return $next($request);
    }
}
