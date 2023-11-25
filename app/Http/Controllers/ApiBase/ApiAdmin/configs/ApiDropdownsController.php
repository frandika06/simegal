<?php

namespace App\Http\Controllers\ApiBase\ApiAdmin\configs;

use App\Http\Controllers\Controller;
use App\Models\AlamatPerusahaan;
use App\Models\PermohonanPeneraan;
use Illuminate\Support\Facades\DB;

class ApiDropdownsController extends Controller
{
    // getAlamatPerusahaan
    public function getAlamatPerusahaan($uuid)
    {
        // get data alamat
        $data = AlamatPerusahaan::whereUuidPerusahaan($uuid)
            ->orderBy("created_at", "ASC")
            ->get();

        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }

    // getListTahunPermohonan
    public function getListTahunPermohonan()
    {
        // get data permohonan
        $data = PermohonanPeneraan::select(DB::raw("YEAR(created_at) year"))
            ->groupBy("year")
            ->orderBy("year", "DESC")
            ->get();

        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }
}
