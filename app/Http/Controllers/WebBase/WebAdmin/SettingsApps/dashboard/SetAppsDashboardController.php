<?php

namespace App\Http\Controllers\WebBase\WebAdmin\SettingsApps\dashboard;

use App\Http\Controllers\Controller;
use App\Models\PermohonanPeneraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SetAppsDashboardController extends Controller
{
    //index
    public function index(Request $request)
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
        return view('pages.admin.settings_apps.dashboard.index', compact(
            'tahun',
            'tahunPermohonan'
        ));
    }
}
