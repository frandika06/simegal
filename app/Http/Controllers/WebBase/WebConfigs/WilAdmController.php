<?php

namespace App\Http\Controllers\WebBase\WebConfigs;

use App\Http\Controllers\Controller;
use App\Models\WilDesa;
use App\Models\WilKabupaten;
use App\Models\WilKecamatan;
use App\Models\WilProvinsi;

class WilAdmController extends Controller
{

    /*
     * DATA
     */
    //dataProvinsi
    public function dataProvinsi()
    {
        $data = WilProvinsi::orderBy("name", "ASC")->get();
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }
    //dataKabupaten
    public function dataKabupaten($id)
    {
        $data = WilKabupaten::where("province_id", $id)->orderBy("name", "ASC")->get();
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }
    //dataKecamatan
    public function dataKecamatan($id)
    {
        $data = WilKecamatan::where("regency_id", $id)->orderBy("name", "ASC")->get();
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }
    //dataDesa
    public function dataDesa($id)
    {
        $data = WilDesa::where("district_id", $id)->orderBy("name", "ASC")->get();
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }

    /*
     * DETAIL
     */
    //detailProvinsi
    public function detailProvinsi($id)
    {
        $data = WilProvinsi::where("id", $id)->firstOrFail();
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }
    //detailKabupaten
    public function detailKabupaten($id)
    {
        $data = WilKabupaten::where("id", $id)
            ->with('Provinsi')
            ->firstOrFail();
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }
    //detailKecamatan
    public function detailKecamatan($id)
    {
        $data = WilKecamatan::where("id", $id)
            ->with('Kabupaten')
            ->with('Kabupaten.Provinsi')
            ->firstOrFail();
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }
    //detailDesa
    public function detailDesa($id)
    {
        $data = WilDesa::where("id", $id)
            ->with('Kecamatan')
            ->with('Kecamatan.Kabupaten')
            ->with('Kecamatan.Kabupaten.Provinsi')
            ->firstOrFail();
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }

    /*
     * SUB STRING
     */
    //substrProvinsi
    public function substrProvinsi($start, $extract, $id)
    {
        $data = WilProvinsi::where(DB::raw("substr(id, $start, $extract)"), '=', $id)
            ->with('Kabupaten')
            ->orderBy("name", "ASC")
            ->get();
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }
    //substrKabupaten
    public function substrKabupaten($start, $extract, $id)
    {
        $data = WilKabupaten::where(DB::raw("substr(id, $start, $extract)"), '=', $id)
            ->with('Provinsi')
            ->orderBy("name", "ASC")
            ->get();
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }
    //substrKecamatan
    public function substrKecamatan($start, $extract, $id)
    {
        $data = WilKecamatan::where(DB::raw("substr(id, $start, $extract)"), '=', $id)
            ->with('Kabupaten')
            ->with('Kabupaten.Provinsi')
            ->orderBy("name", "ASC")
            ->get();
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }
    //substrDesa
    public function substrDesa($start, $extract, $id)
    {
        $data = WilDesa::where(DB::raw("substr(id, $start, $extract)"), '=', $id)
            ->with('Kecamatan')
            ->with('Kecamatan.Kabupaten')
            ->with('Kecamatan.Kabupaten.Provinsi')
            ->orderBy("name", "ASC")
            ->get();
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }
}
