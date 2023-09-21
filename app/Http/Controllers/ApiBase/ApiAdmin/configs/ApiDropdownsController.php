<?php

namespace App\Http\Controllers\ApiBase\ApiAdmin\configs;

use App\Http\Controllers\Controller;
use App\Models\AlamatPerusahaan;

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
}
