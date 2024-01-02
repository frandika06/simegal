<?php

namespace App\Http\Controllers\ApiBase\ApiAdmin\configs;

use App\Helpers\CID;
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

    // getListInstrumenGroup
    public function getListInstrumenGroup()
    {
        $response = [
            "status" => true,
            "data" => CID::getListInstrumenGByJenisUttp(),
        ];
        return response()->json($response, 200);
    }

    // getListInstrumenItemUttp
    public function getListInstrumenItemUttp($uuid)
    {
        $response = [
            "status" => true,
            "data" => CID::getListInstrumenByJenisUttp($uuid),
        ];
        return response()->json($response, 200);
    }

    // getListAlat
    public function getListAlat($tags, $uuid)
    {
        $dataAlat = [];
        $dataCtt = [];
        foreach (CID::getListAlat($tags, $uuid) as $item) {
            if ($item->kategori == '1') {
                $dataAlat[] = $item;
            } elseif ($item->kategori == '2') {
                $dataCtt[] = $item;
            }
        }

        // data
        $data = [
            "alat_standar" => $dataAlat,
            "ctt" => $dataCtt,
        ];
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }
}
