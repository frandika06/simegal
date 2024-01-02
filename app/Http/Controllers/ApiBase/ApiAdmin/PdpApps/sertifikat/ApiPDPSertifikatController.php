<?php

namespace App\Http\Controllers\ApiBase\ApiAdmin\PdpApps\sertifikat;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PermohonanPeneraan;

class ApiPDPSertifikatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // auth
        $auth = auth()->user();
        $profile = $auth->RelPerusahaan;

        $dataSertifikat = PermohonanPeneraan::join("pdp_penjadwalan", "pdp_penjadwalan.uuid_permohonan", "=", "permohonan_peneraan.uuid")
            ->join("tte_skhp", "tte_skhp.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")
            ->select("permohonan_peneraan.*")
            ->with('RelPerusahaan')
            ->with('RelPdpPenjadwalan')
            ->with('RelPdpPenjadwalan.RelTteSkhp')
            ->where("permohonan_peneraan.uuid_perusahaan", $profile->uuid)
            ->where("tte_skhp.status_acc", "1")
            ->where("tte_skhp.status_aktif", "1")
            ->orderBy("tte_skhp.tanggal_expired", "DESC")
            ->get();

        if (count($dataSertifikat) > 0) {
            $data = [];
            foreach ($dataSertifikat as $item) {
                $urlFileSKHP = CID::urlImg($item->RelPdpPenjadwalan->RelTteSkhp->file_skhp);
                $urlUnduhFileSKHP = route('exdown.unduh.skhp', [$item->RelPdpPenjadwalan->RelTteSkhp->kode_tte]);
                $data[] = $item;
                $item->file_skhp = $urlFileSKHP;
                $item->unduh_skhp = $urlUnduhFileSKHP;
            }
        } else {
            $data = $dataSertifikat;
        }

        // response
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }
}
