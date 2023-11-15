<?php

namespace App\Http\Controllers\WebBase\WebConfigs;

use App\Http\Controllers\Controller;
use App\Models\MasterKelompokUttp;
use App\Models\PdpPenjadwalan;
use App\Models\PermohonanPeneraan;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    // SetGetKelompokUttp
    public function SetGetKelompokUttp(Request $request)
    {
        // uuid jenis pelayanan
        $uuid_jenis_pelayanan = $request->uuid;
        $data = MasterKelompokUttp::whereUuidJenisPelayanan($uuid_jenis_pelayanan)
            ->orderBy("no_urut", "ASC")
            ->get();

        // response
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }

    // ScdStatistikPermohonan
    public function ScdStatistikPermohonan(Request $request)
    {
        // request
        $tahun = $request->tahun;
        $tags = $request->tags;

        $baru = PermohonanPeneraan::join("perusahaan", "perusahaan.uuid", "=", "permohonan_peneraan.uuid_perusahaan")
            ->select("permohonan_peneraan.*")
            ->where("perusahaan.file_npwp", "!=", null)
            ->where("perusahaan.verifikasi", "=", "1")
            ->whereYear("permohonan_peneraan.tanggal_permohonan", $tahun)
            ->where("permohonan_peneraan.jenis_pengujian", $tags)
            ->where("permohonan_peneraan.status", "Baru")
            ->where("perusahaan.status", "=", "1")
            ->orderBy("permohonan_peneraan.created_at", "DESC")
            ->count();
        $diproses = PermohonanPeneraan::join("perusahaan", "perusahaan.uuid", "=", "permohonan_peneraan.uuid_perusahaan")
            ->select("permohonan_peneraan.*")
            ->where("perusahaan.file_npwp", "!=", null)
            ->where("perusahaan.verifikasi", "=", "1")
            ->whereYear("permohonan_peneraan.tanggal_permohonan", $tahun)
            ->where("permohonan_peneraan.jenis_pengujian", $tags)
            ->where("permohonan_peneraan.status", "Diproses")
            ->where("perusahaan.status", "=", "1")
            ->orderBy("permohonan_peneraan.created_at", "DESC")
            ->count();
        $selesai = PermohonanPeneraan::join("perusahaan", "perusahaan.uuid", "=", "permohonan_peneraan.uuid_perusahaan")
            ->select("permohonan_peneraan.*")
            ->where("perusahaan.file_npwp", "!=", null)
            ->where("perusahaan.verifikasi", "=", "1")
            ->whereYear("permohonan_peneraan.tanggal_permohonan", $tahun)
            ->where("permohonan_peneraan.jenis_pengujian", $tags)
            ->where("permohonan_peneraan.status", "Selesai")
            ->where("perusahaan.status", "=", "1")
            ->orderBy("permohonan_peneraan.created_at", "DESC")
            ->count();
        $ditolak = PermohonanPeneraan::join("perusahaan", "perusahaan.uuid", "=", "permohonan_peneraan.uuid_perusahaan")
            ->select("permohonan_peneraan.*")
            ->where("perusahaan.file_npwp", "!=", null)
            ->where("perusahaan.verifikasi", "=", "1")
            ->whereYear("permohonan_peneraan.tanggal_permohonan", $tahun)
            ->where("permohonan_peneraan.jenis_pengujian", $tags)
            ->where("permohonan_peneraan.status", "Ditolak")
            ->where("perusahaan.status", "=", "1")
            ->orderBy("permohonan_peneraan.created_at", "DESC")
            ->count();

        // data
        $data = [
            "jml_status_baru" => $baru,
            "jml_status_diproses" => $diproses,
            "jml_status_selesai" => $selesai,
            "jml_status_ditolak" => $ditolak,
        ];

        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }

    // ScdStatistikInputData
    public function ScdStatistikInputData(Request $request)
    {
        // request
        $tahun = $request->tahun;
        $tera = PermohonanPeneraan::join("perusahaan", "perusahaan.uuid", "=", "permohonan_peneraan.uuid_perusahaan")
            ->select("permohonan_peneraan.*")
            ->where("perusahaan.file_npwp", "!=", null)
            ->where("perusahaan.verifikasi", "=", "1")
            ->whereYear("permohonan_peneraan.tanggal_permohonan", $tahun)
            ->where("permohonan_peneraan.jenis_pengujian", 'Tera')
            ->where("permohonan_peneraan.status", "Diproses")
            ->where("perusahaan.status", "=", "1")
            ->orderBy("permohonan_peneraan.created_at", "DESC")
            ->get();
        $teraUlang = PermohonanPeneraan::join("perusahaan", "perusahaan.uuid", "=", "permohonan_peneraan.uuid_perusahaan")
            ->select("permohonan_peneraan.*")
            ->where("perusahaan.file_npwp", "!=", null)
            ->where("perusahaan.verifikasi", "=", "1")
            ->whereYear("permohonan_peneraan.tanggal_permohonan", $tahun)
            ->where("permohonan_peneraan.jenis_pengujian", 'Tera Ulang')
            ->where("permohonan_peneraan.status", "Diproses")
            ->where("perusahaan.status", "=", "1")
            ->orderBy("permohonan_peneraan.created_at", "DESC")
            ->get();
        $bdkt = PermohonanPeneraan::join("perusahaan", "perusahaan.uuid", "=", "permohonan_peneraan.uuid_perusahaan")
            ->select("permohonan_peneraan.*")
            ->where("perusahaan.file_npwp", "!=", null)
            ->where("perusahaan.verifikasi", "=", "1")
            ->whereYear("permohonan_peneraan.tanggal_permohonan", $tahun)
            ->where("permohonan_peneraan.jenis_pengujian", 'Pengujian BDKT')
            ->where("permohonan_peneraan.status", "Diproses")
            ->where("perusahaan.status", "=", "1")
            ->orderBy("permohonan_peneraan.created_at", "DESC")
            ->get();
        // cek data tera
        $dataTera = [];
        foreach ($tera as $item) {
            $uuid_permohonan = $item->uuid;
            $pdp = PdpPenjadwalan::whereUuidPermohonan($uuid_permohonan)->first();
            if ($pdp === null) {
                $dataTera[] = $item;
            }
        }
        // cek data tera ulang
        $dataTeraUlang = [];
        foreach ($teraUlang as $item) {
            $uuid_permohonan = $item->uuid;
            $pdp = PdpPenjadwalan::whereUuidPermohonan($uuid_permohonan)->first();
            if ($pdp === null) {
                $dataTeraUlang[] = $item;
            }
        }
        // cek data bdkt
        $dataBdkt = [];
        foreach ($bdkt as $item) {
            $uuid_permohonan = $item->uuid;
            $pdp = PdpPenjadwalan::whereUuidPermohonan($uuid_permohonan)->first();
            if ($pdp === null) {
                $dataBdkt[] = $item;
            }
        }
        // data
        $data = [
            "jml_tera" => count($dataTera),
            "jml_tera_ulang" => count($dataTeraUlang),
            "jml_bdkt" => count($dataBdkt),
        ];

        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }

    // ScdStatistikPenugasan
    public function ScdStatistikPenugasan(Request $request)
    {
        // request
        $tahun = $request->tahun;
        $status = $request->status;
        $tera = PdpPenjadwalan::join("permohonan_peneraan", "permohonan_peneraan.uuid", "=", "pdp_penjadwalan.uuid_permohonan")
            ->select("pdp_penjadwalan.*")
            ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
            ->where("pdp_penjadwalan.status_peneraan", $status)
            ->where("permohonan_peneraan.jenis_pengujian", 'Tera')
            ->orderBy("pdp_penjadwalan.tanggal_peneraan", "DESC")
            ->count();
        $teraUlang = PdpPenjadwalan::join("permohonan_peneraan", "permohonan_peneraan.uuid", "=", "pdp_penjadwalan.uuid_permohonan")
            ->select("pdp_penjadwalan.*")
            ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
            ->where("pdp_penjadwalan.status_peneraan", $status)
            ->where("permohonan_peneraan.jenis_pengujian", 'Tera Ulang')
            ->orderBy("pdp_penjadwalan.tanggal_peneraan", "DESC")
            ->count();
        $bdkt = PdpPenjadwalan::join("permohonan_peneraan", "permohonan_peneraan.uuid", "=", "pdp_penjadwalan.uuid_permohonan")
            ->select("pdp_penjadwalan.*")
            ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
            ->where("pdp_penjadwalan.status_peneraan", $status)
            ->where("permohonan_peneraan.jenis_pengujian", 'Pengujian BDKT')
            ->orderBy("pdp_penjadwalan.tanggal_peneraan", "DESC")
            ->count();
        // data
        $data = [
            "jml_tera" => $tera,
            "jml_tera_ulang" => $teraUlang,
            "jml_bdkt" => $bdkt,
        ];

        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }
}
