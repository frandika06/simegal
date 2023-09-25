<?php

namespace App\Http\Controllers\WebBase\WebAdmin\configs;

use App\Http\Controllers\Controller;
use App\Models\SysLogAktifitas;
use App\Models\SysLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class BaseAppsController extends Controller
{
    public function index(Request $request)
    {
        // auth
        $auth = Auth::user();
        $role = $auth->role;
        $sub_role = $auth->sub_role;
        $sub_sub_role = $auth->sub_sub_role;

        // background
        $pageBg = Cache::get('pageBg');
        if ($pageBg === null) {
            $bgNumber = rand(1, 31);
            // Cache::put('pageBg', $bgNumber, now()->addHours(24));
            Cache::put('pageBg', $bgNumber, now()->addMinutes(1));
            $pageBg = $bgNumber;
        } else {
            $pageBg = $pageBg;
        }

        // Admin System
        if ($role == "Admin System" || $role == "Super Admin") {
            return $this->adminSystem($request, $pageBg);
        } elseif ($role == "Pegawai") {
            // PEGAWAI
            if ($sub_role == "Admin Portal") {
                return redirect()->route('prt.apps.home.index');
            } else {
                return abort(404);
            }
        } elseif ($role == "Perusahaan") {
            // Perusahaan
            return redirect()->route('pdp.apps.home.index');
        } else {
            return abort(404);
        }
    }

    // adminSystem
    private function adminSystem($request, $pageBg)
    {
        $dataLogs = [];
        $logAktifitas = SysLogAktifitas::where("dashboard", "1")
            ->orderBy("created_at", "DESC")
            ->limit(50)
            ->get();
        foreach ($logAktifitas as $item) {
            $item->tipe = "logs";
            $dataLogs[] = $item;
        }

        $loginLogs = SysLogin::orderBy("created_at", "DESC")
            ->limit(50)
            ->get();
        foreach ($loginLogs as $item) {
            if ($item->publisher !== null) {
                $item->tipe = "login";
                $dataLogs[] = $item;
            }
        }

        // return $dataLogs;
        return view('pages.admin.list_apps.admin', compact(
            'dataLogs',
            'pageBg'
        ));
    }
}
