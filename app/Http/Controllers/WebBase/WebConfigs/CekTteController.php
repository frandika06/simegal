<?php

namespace App\Http\Controllers\WebBase\WebConfigs;

use App\Http\Controllers\Controller;
use App\Models\TteSkhp;

class CekTteController extends Controller
{
    //indexSkhp
    public function indexSkhp($kode_tte)
    {
        $data = TteSkhp::where("kode_tte", $kode_tte)->first();
        return $data;
    }
}
