<?php

namespace App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\dashboard;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PermohonanPeneraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScdDashboardController extends Controller
{
    // index
    public function index(Request $request)
    {
        // auth
        $auth = Auth::user();
        $role = $auth->role;

        // Admin System
        if ($role == "Admin System" || $role == "Super Admin") {
            return $this->indexAdminSystem($request);
        } elseif ($role == "Pegawai") {
            // PEGAWAI
            if (CID::subRoleAdmin() == true) {
                // Admin Aplikasi
                return $this->indexAdminSystem($request);
            } elseif (CID::subRoleVerifikator() == true) {
                // Verifikator
                return $this->indexAdminSystem($request);
            } elseif (CID::subRoleKepalaTim() == true) {
                // Kasi
                return $this->indexAdminSystem($request);
            } elseif (CID::subRolePetugas() == true) {
                // petugas
                return $this->indexAdminSystem($request);
            } else {
                return redirect()->route('auth.home');
            }
        } else {
            return redirect()->route('auth.home');
        }
    }

    // index super admin
    private function indexAdminSystem($request)
    {
        // cek filter
        if ($request->session()->exists('filter_tahun')) {
            $tahun = $request->session()->get('filter_tahun');
        } else {
            $request->session()->put('filter_tahun', date('Y'));
            $tahun = date('Y');
        }

        // cek data permohonan
        $tahunPermohonan = PermohonanPeneraan::select(DB::raw("YEAR(created_at) year"))
            ->groupBy("year")
            ->orderBy("year", "DESC")
            ->get();

        return view('pages.admin.schedule_apps.dashboard.index_admin', compact(
            'tahun',
            'tahunPermohonan'
        ));
    }
}
