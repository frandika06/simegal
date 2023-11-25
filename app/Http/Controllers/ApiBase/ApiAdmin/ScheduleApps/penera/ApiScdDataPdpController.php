<?php

namespace App\Http\Controllers\ApiBase\ApiAdmin\ScheduleApps\penera;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PdpPenjadwalan;
use App\Models\PermohonanPeneraan;
use Illuminate\Http\Request;

class ApiScdDataPdpController extends Controller
{
    //index
    public function index($tahun, $status, $tags)
    {
        // auth
        $auth = auth()->user();

        // base data
        $dataArray = [];
        $data = PdpPenjadwalan::join("permohonan_peneraan", "permohonan_peneraan.uuid", "=", "pdp_penjadwalan.uuid_permohonan")
            ->select("pdp_penjadwalan.*")
            ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
            ->where("permohonan_peneraan.jenis_pengujian", $tags)
            ->orderBy("pdp_penjadwalan.tanggal_peneraan", "ASC")
            ->orderBy("pdp_penjadwalan.jam_peneraan", "ASC");

        // Semua Data
        if ($status != "All") {
            $data = $data->where("pdp_penjadwalan.status_peneraan", $status);
        }

        // hak akses
        $subRoleOnlyPetugas = CID::subRoleOnlyPetugas();
        if ($subRoleOnlyPetugas == true) {
            // hanya petugas
            $uuid_profile = $auth->uuid_profile;
            $data = $data->join("pdp_data_petugas", "pdp_data_petugas.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")
                ->where("pdp_data_petugas.uuid_pegawai", $uuid_profile)->get();
        } else {
            $data = $data->get();
        }

        // foreach
        foreach ($data as $item) {
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
            $dataArray[] = $item;
        }

        // response
        $response = [
            "status" => true,
            "data" => $dataArray,
        ];
        return response()->json($response, 200);
    }

    /*
    | show
     */
    // show
    public function show($uuid)
    {
        // auth
        $auth = auth()->user();

        // base data
        $data = PdpPenjadwalan::whereUuid($uuid)
            ->with("RelPermohonanPeneraan")
            ->with("RelPermohonanPeneraan.RelPerusahaan")
            ->with("RelPermohonanPeneraan.RelAlamatPerusahaan")
            ->with("RelPermohonanPeneraan.RelVerifikator")
            ->with("RelMasterKelompokUttp")
            ->with("RelDiproses")
            ->with("RelDitunda")
            ->with("RelDibatalkan")
            ->with("RelSelesai")
            ->with("RelGetPetugasTAP")
            ->with("RelGetPetugasPT");

        // hak akses
        $subRoleOnlyPetugas = CID::subRoleOnlyPetugas();
        if ($subRoleOnlyPetugas == true) {
            // hanya petugas
            $uuid_profile = $auth->uuid_profile;
            $data = $data->join("pdp_data_petugas", "pdp_data_petugas.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")
                ->where("pdp_data_petugas.uuid_pegawai", $uuid_profile)->firstOrFail();
        } else {
            $data = $data->firstOrFail();
        }

        // response
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }

    /**
     * Status Aktif
     */
    public function status(Request $request)
    {
        // auth
        $auth = auth()->user();

        // uuid
        $uuid = $request->uuid;
        $status = $request->status;

        // data
        $data = PdpPenjadwalan::findOrFail($uuid);

        // cek status
        $list_status = [
            "Selesai",
            "Dibatalkan",
            "Ditunda",
            "Diproses",
        ];
        if (!in_array($status, $list_status)) {
            // response
            $response = [
                "status" => false,
                "message" => "Status Yang Anda Masukkan Salah!",
            ];
            return response()->json($response, 422);
        }
        if ($data->status_peneraan == $status) {
            // response
            $response = [
                "status" => false,
                "message" => "Status Tidak Berubah, Cek Kembali Data Yang Anda Masukkan!",
            ];
            return response()->json($response, 422);
        }

        // value
        $value_1 = [
            "status_peneraan" => $status,
            "uuid_updated" => $auth->uuid_profile,
        ];

        if ($status == "Diproses") {
            $value_1['uuid_diproses'] = $auth->uuid_profile;
        } elseif ($status == "Ditunda") {
            $value_1['uuid_ditunda'] = $auth->uuid_profile;
        } elseif ($status == "Dibatalkan") {
            $value_1['uuid_dibatalkan'] = $auth->uuid_profile;
            // ubah status permohonan jadi ditolak
            $uuid_permohonan = $data->uuid_permohonan;
            // value permohonan
            $value_2 = [
                "status" => "Ditolak",
                "uuid_updated" => $auth->uuid_profile,
            ];
            PermohonanPeneraan::whereUuid($uuid_permohonan)->update($value_2);
        } elseif ($status == "Selesai") {
            $value_1['uuid_selesai'] = $auth->uuid_profile;
        }

        // save
        $save_1 = $data->update($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("pdp_penjadwalan"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Schedule Apps",
                "subjek" => "Mengubah Status Jadawal & Penugasan Menjadi : " . $status . " - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "mobile",
                "dashboard" => "1",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            $msg = "Berhasil Merubah Status Jadawal & Penugasan Menjadi: " . $status . "!";
            $response = [
                "status" => true,
                "message" => $msg,
            ];
            return response()->json($response, 200);
        } else {
            // gagal
            $msg = "Gagal Melakukan Perubahan Status Jadawal & Penugasan!";
            $response = [
                "status" => false,
                "message" => $msg,
            ];
            return response()->json($response, 422);
        }
    }
}
