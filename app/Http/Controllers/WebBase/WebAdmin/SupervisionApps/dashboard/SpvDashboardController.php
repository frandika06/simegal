<?php

namespace App\Http\Controllers\WebBase\WebAdmin\SupervisionApps\dashboard;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PermohonanPeneraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SpvDashboardController extends Controller
{
    // index
    public function index(Request $request)
    {
        // auth
        $auth = Auth::user();
        $role = $auth->role;

        // Admin System
        if ($role == "Admin System" || $role == "Super Admin" || $role == "Kepala Dinas" || $role == "Kepala Bidang") {
            return $this->indexGeneral($request);
        } elseif ($role == "Pegawai") {
            // PEGAWAI
            if (CID::subRolePegawai() == true) {
                // Admin Aplikasi
                return $this->indexGeneral($request);
            } else {
                return redirect()->route('auth.home');
            }
        } else {
            return redirect()->route('auth.home');
        }
    }

    // index general
    private function indexGeneral($request)
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

        return view('pages.admin.supervision_apps.dashboard.index_admin', compact(
            'tahun',
            'tahunPermohonan'
        ));
    }
}
