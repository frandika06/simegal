<?php

namespace App\Http\Controllers\WebBase\WebAdmin\PdpApps\sertifikat;

use App\Http\Controllers\Controller;
use App\Models\PermohonanPeneraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PDPSertifikatSKHPController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // auth
        $auth = Auth::user();
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

        return view('pages.admin.pdp_apps.sertifikat.index', compact(
            'profile',
            'dataSertifikat',
        ));
    }
}
