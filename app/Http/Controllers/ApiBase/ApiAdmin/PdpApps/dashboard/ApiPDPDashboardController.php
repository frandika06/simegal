<?php

namespace App\Http\Controllers\ApiBase\ApiAdmin\PdpApps\dashboard;

use App\Http\Controllers\Controller;
use App\Models\PermohonanPeneraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiPDPDashboardController extends Controller
{
    // index
    public function index(Request $request, $tahun, $status)
    {
        // auth
        $auth = auth()->user();
        $profile = $auth->RelPerusahaan;

        // cek data permohonan
        $tahunPermohonan = PermohonanPeneraan::select(DB::raw("YEAR(created_at) year"))
            ->groupBy("year")
            ->orderBy("year", "DESC")
            ->get();
        if (count($tahunPermohonan) > 0) {
            $list_tahun = $tahunPermohonan;
        } else {
            $list_tahun = date('Y');
        }

        // PermohonanPeneraan
        if ($status == "Semua Data") {
            $PermohonanPeneraan = PermohonanPeneraan::with('RelPerusahaan')
                ->with('RelAlamatPerusahaan')
                ->with('RelVerifikator')
                ->whereUuidPerusahaan($profile->uuid)
                ->whereYear("tanggal_permohonan", $tahun)
                ->orderBy("created_at", "DESC")
                ->get();
        } else {
            $PermohonanPeneraan = PermohonanPeneraan::with('RelPerusahaan')
                ->with('RelAlamatPerusahaan')
                ->with('RelVerifikator')
                ->whereUuidPerusahaan($profile->uuid)
                ->whereYear("tanggal_permohonan", $tahun)
                ->whereStatus($status)
                ->orderBy("created_at", "DESC")
                ->get();
        }

        // response
        $data = [
            "list_tahun" => $list_tahun,
            "data_permohonan" => $PermohonanPeneraan,
        ];
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }
}
