<?php

namespace App\Http\Controllers\ApiBase\ApiAdmin\SettingsApps\master;

use App\Helpers\CID;
use App\Http\Controllers\Controller;

class ApiSetAppsFiturController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($nama_fitur)
    {
        $data = CID::getMasterFitur($nama_fitur);

        // response
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }
}
