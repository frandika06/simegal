<?php

namespace App\Http\Controllers\WebBase\WebAdmin\configs;

use App\Helpers\CID;
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
            return $this->listApps($request, $pageBg);
        } elseif ($role == "Pegawai") {
            // PEGAWAI
            $subRolePegawai = CID::subRolePegawai();
            if ($subRolePegawai == false) {
                return redirect()->route('prt.apps.home.index');
            } else {
                return $this->listApps($request, $pageBg);
            }
        } elseif ($role == "Perusahaan") {
            // Perusahaan
            return redirect()->route('pdp.apps.home.index');
        } else {
            return abort(404);
        }
    }

    // listApps
    private function listApps($request, $pageBg)
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
            $item->tipe = "login";
            $dataLogs[] = $item;
        }

        return view('pages.admin.list_apps.list_apps', compact(
            'dataLogs',
            'pageBg'
        ));
    }
}