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
            return $this->listApps($request, $pageBg, $auth);
        } elseif ($role == "Pegawai") {
            // PEGAWAI
            $subRolePegawai = CID::subRolePegawai();
            if ($subRolePegawai == false) {
                // cek admin portal
                $subRoleAdminPortal = CID::subRoleAdminPortal();
                if ($subRoleAdminPortal == true) {
                    return redirect()->route('prt.apps.home.index');
                } else {
                    Auth::logout();
                    alert()->warning('Akses Ditolak!', 'Anda Tidak Memiliki Hak Akses!');
                    return \redirect()->route('prt.lgn.index');
                }
            } else {
                return $this->listApps($request, $pageBg, $auth);
            }
        } elseif ($role == "Perusahaan") {
            // Perusahaan
            return redirect()->route('pdp.apps.home.index');
        } elseif ($role == "Kepala Dinas" || $role == "Kepala Bidang") {
            // Kepala Dinas || Kepala Bidang
            return $this->listAppsKepala($request, $pageBg, $auth);
        } else {
            Auth::logout();
            alert()->warning('Akses Ditolak!', 'Anda Tidak Memiliki Hak Akses!');
            return \redirect()->route('prt.lgn.index');
        }
    }

    // listApps
    private function listApps($request, $pageBg, $auth)
    {
        // auth
        $role = $auth->role;

        $dataLogs = [];
        $logAktifitas = SysLogAktifitas::where("dashboard", "1")
            ->orderBy("created_at", "DESC")
            ->limit(50);
        $loginLogs = SysLogin::orderBy("created_at", "DESC")
            ->limit(50);
        if ($role == "Admin System" || $role == "Super Admin") {
            $logAktifitas = $logAktifitas->get();
            $loginLogs = $loginLogs->get();
        } else {
            $subRoleAdmin = CID::subRoleAdmin();
            if ($subRoleAdmin == true) {
                $logAktifitas = $logAktifitas->get();
                $loginLogs = $loginLogs->get();
            } else {
                $logAktifitas = $logAktifitas->where("uuid_profile", $auth->uuid_profile)->get();
                $loginLogs = $loginLogs->where("uuid_profile", $auth->uuid_profile)->get();
            }
        }
        foreach ($logAktifitas as $item) {
            $item->tipe = "logs";
            $dataLogs[] = $item;
        }
        foreach ($loginLogs as $item) {
            $item->tipe = "login";
            $dataLogs[] = $item;
        }

        return view('pages.admin.list_apps.list_apps_tiga', compact(
            'dataLogs',
            'pageBg'
        ));
    }

    // listAppsKepala
    private function listAppsKepala($request, $pageBg, $auth)
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

        return view('pages.admin.list_apps.list_apps_kepala', compact(
            'dataLogs',
            'pageBg'
        ));
    }
}
