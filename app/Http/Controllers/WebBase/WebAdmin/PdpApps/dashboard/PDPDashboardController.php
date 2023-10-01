<?php

namespace App\Http\Controllers\WebBase\WebAdmin\PdpApps\dashboard;

use App\Http\Controllers\Controller;
use App\Models\PermohonanPeneraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PDPDashboardController extends Controller
{
    // index
    public function index(Request $request)
    {
        // auth
        $auth = Auth::user();
        $role = $auth->role;
        $sub_role = $auth->sub_role;
        $sub_sub_role = $auth->sub_sub_role;

        // Admin System
        if ($role == "Admin System" || $role == "Super Admin") {
            return $role;
        } elseif ($role == "Pegawai") {
            // PEGAWAI
            if ($sub_role == "Admin Aplikasi") {
                return $sub_role;
            } elseif ($sub_role == "Petugas") {
                return $sub_role;
            } elseif ($sub_role == "Kasi") {
                return $sub_role;
            } else {
                return redirect()->route('auth.home');
            }
        } elseif ($role == "Perusahaan") {
            // Perusahaan
            return $this->indexPerusahaan($request);
        } else {
            return redirect()->route('auth.home');
        }
    }
    // index perusahaan
    private function indexPerusahaan($request)
    {
        // auth
        $auth = Auth::user();
        $profile = $auth->RelPerusahaan;

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

        return view('pages.admin.pdp_apps.dashboard.index', compact(
            'profile',
            'tahun',
            'tahunPermohonan'
        ));
    }
}
