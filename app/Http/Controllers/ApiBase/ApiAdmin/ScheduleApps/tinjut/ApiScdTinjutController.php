<?php

namespace App\Http\Controllers\ApiBase\ApiAdmin\ScheduleApps\tinjut;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\MasterKelompokUttp;
use App\Models\PdpPenjadwalan;

class ApiScdTinjutController extends Controller
{
    //index
    public function index($tahun, $tags_jp, $tags)
    {
        // auth
        $auth = auth()->user();

        // base data
        $dataArray = [];

        // get kelompok uttp
        $getKelompokUttp = MasterKelompokUttp::join("master_jenis_pelayanan", "master_jenis_pelayanan.uuid", "=", "master_kelompok_uttp.uuid_jenis_pelayanan")
            ->select("master_kelompok_uttp.*")
            ->where("master_jenis_pelayanan.nama_pelayanan", $tags)
            ->where("master_kelompok_uttp.kode", $tags_jp)
            ->firstOrFail();
        $uuid_kelompok_uttp = $getKelompokUttp->uuid;

        // hak akses
        $subRoleOnlyPetugas = CID::subRoleOnlyPetugas();
        if ($subRoleOnlyPetugas == true) {
            // hanya petugas
            $uuid_profile = $auth->uuid_profile;
            $data = PdpPenjadwalan::join("pdp_data_petugas", "pdp_data_petugas.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")
                ->select("pdp_penjadwalan.*")
                ->where("pdp_penjadwalan.uuid_kelompok_uttp", $uuid_kelompok_uttp)
                ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
                ->whereIn("pdp_penjadwalan.status_peneraan", ["Diproses", "Selesai"])
                ->where("pdp_data_petugas.uuid_pegawai", $uuid_profile)
                ->orderBy("tanggal_peneraan", "ASC")
                ->orderBy("jam_peneraan", "ASC")
                ->get();
        } else {
            $data = PdpPenjadwalan::where("uuid_kelompok_uttp", $uuid_kelompok_uttp)
                ->whereYear("tanggal_peneraan", $tahun)
                ->whereIn("status_peneraan", ["Diproses", "Selesai"])
                ->orderBy("tanggal_peneraan", "ASC")
                ->orderBy("jam_peneraan", "ASC")
                ->get();
        }

        // foreach
        foreach ($data as $item) {
            $enc_uuid = CID::encode($item->uuid);
            // route print
            $routeSuratJalan = route('print.pdp.sj', [$enc_uuid]);
            $routeSuratPerintah = route('print.pdp.spt', [$enc_uuid]);
            $routeDisposisi = route('print.pdp.disposisi', [$enc_uuid]);
            // relasi
            $data->RelPermohonanPeneraan = $item->RelPermohonanPeneraan;
            $data->RelPerusahaan = $item->RelPermohonanPeneraan->RelPerusahaan;
            $data->RelAlamatPerusahaan = $item->RelPermohonanPeneraan->RelAlamatPerusahaan;
            $data->RelVerifikator = $item->RelPermohonanPeneraan->RelVerifikator;
            $data->RelMasterKelompokUttp = $item->RelMasterKelompokUttp;
            $data->RelDiproses = $item->RelDiproses;
            $data->RelDitunda = $item->RelDitunda;
            $data->RelDibatalkan = $item->RelDibatalkan;
            $data->RelSelesai = $item->RelSelesai;
            $data->RelTenagaAhliPenera = $item->RelGetPetugasTAP;
            $data->RelPendampingTeknis = $item->RelGetPetugasPT;
            $data->RelPdpInstrumenOrder = $item->RelPdpInstrumenOrder;
            $data->RelPdpAlatOrder = $item->RelPdpAlatOrder;
            $item->action_print = [
                "surat_jalan" => $routeSuratJalan,
                "surat_perintah" => $routeSuratPerintah,
                "kartu_penerus_disposisi" => $routeDisposisi,
            ];
            $dataArray[] = $item;
        }

        // response
        $response = [
            "status" => true,
            "data" => $dataArray,
        ];
        return response()->json($response, 200);
    }
}
