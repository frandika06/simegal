<?php

namespace App\Http\Controllers\WebBase\WebConfigs;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\MasterKelompokUttp;
use App\Models\PdpPenjadwalan;
use App\Models\Pegawai;
use App\Models\PermohonanPeneraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // auth
        $auth = Auth::user();

        // request
        $tahun = $request->tahun;
        $status = $request->status;
        $tera = PdpPenjadwalan::join("permohonan_peneraan", "permohonan_peneraan.uuid", "=", "pdp_penjadwalan.uuid_permohonan")
            ->select("pdp_penjadwalan.*")
            ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
            ->where("permohonan_peneraan.jenis_pengujian", 'Tera');
        $teraUlang = PdpPenjadwalan::join("permohonan_peneraan", "permohonan_peneraan.uuid", "=", "pdp_penjadwalan.uuid_permohonan")
            ->select("pdp_penjadwalan.*")
            ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
            ->where("permohonan_peneraan.jenis_pengujian", 'Tera Ulang');
        $bdkt = PdpPenjadwalan::join("permohonan_peneraan", "permohonan_peneraan.uuid", "=", "pdp_penjadwalan.uuid_permohonan")
            ->select("pdp_penjadwalan.*")
            ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
            ->where("permohonan_peneraan.jenis_pengujian", 'Pengujian BDKT');

        // Semua Data
        if ($status != "All") {
            $tera = $tera->where("pdp_penjadwalan.status_peneraan", $status);
            $teraUlang = $teraUlang->where("pdp_penjadwalan.status_peneraan", $status);
            $bdkt = $bdkt->where("pdp_penjadwalan.status_peneraan", $status);
        }

        // hak akses
        $subRoleOnlyPetugas = CID::subRoleOnlyPetugas();
        if ($subRoleOnlyPetugas == true) {
            // hanya petugas
            $uuid_profile = $auth->uuid_profile;
            $tera = $tera->join("pdp_data_petugas", "pdp_data_petugas.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")->where("pdp_data_petugas.uuid_pegawai", $uuid_profile)->count();
            $teraUlang = $teraUlang->join("pdp_data_petugas", "pdp_data_petugas.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")->where("pdp_data_petugas.uuid_pegawai", $uuid_profile)->count();
            $bdkt = $bdkt->join("pdp_data_petugas", "pdp_data_petugas.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")->where("pdp_data_petugas.uuid_pegawai", $uuid_profile)->count();
        } else {
            $tera = $tera->count();
            $teraUlang = $teraUlang->count();
            $bdkt = $bdkt->count();
        }

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

    // ScdStatistikInsAlat
    public function ScdStatistikInsAlat(Request $request)
    {
        // auth
        $auth = Auth::user();

        // request
        $tahun = $request->tahun;
        $status = $request->status;
        $tera = PdpPenjadwalan::join("permohonan_peneraan", "permohonan_peneraan.uuid", "=", "pdp_penjadwalan.uuid_permohonan")
            ->select("pdp_penjadwalan.*")
            ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
            ->where("permohonan_peneraan.jenis_pengujian", 'Tera');
        $teraUlang = PdpPenjadwalan::join("permohonan_peneraan", "permohonan_peneraan.uuid", "=", "pdp_penjadwalan.uuid_permohonan")
            ->select("pdp_penjadwalan.*")
            ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
            ->where("permohonan_peneraan.jenis_pengujian", 'Tera Ulang');
        $bdkt = PdpPenjadwalan::join("permohonan_peneraan", "permohonan_peneraan.uuid", "=", "pdp_penjadwalan.uuid_permohonan")
            ->select("pdp_penjadwalan.*")
            ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
            ->where("permohonan_peneraan.jenis_pengujian", 'Pengujian BDKT');

        // Semua Data
        if ($status == "All") {
            $tera = $tera->where("pdp_penjadwalan.status_peneraan", "!=", "Menunggu");
            $teraUlang = $teraUlang->where("pdp_penjadwalan.status_peneraan", "!=", "Menunggu");
            $bdkt = $bdkt->where("pdp_penjadwalan.status_peneraan", "!=", "Menunggu");
        } else {
            $tera = $tera->where("pdp_penjadwalan.status_peneraan", $status);
            $teraUlang = $teraUlang->where("pdp_penjadwalan.status_peneraan", $status);
            $bdkt = $bdkt->where("pdp_penjadwalan.status_peneraan", $status);
        }

        // hak akses
        $subRoleOnlyPetugas = CID::subRoleOnlyPetugas();
        if ($subRoleOnlyPetugas == true) {
            // hanya petugas
            $uuid_profile = $auth->uuid_profile;
            $tera = $tera->join("pdp_data_petugas", "pdp_data_petugas.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")->where("pdp_data_petugas.uuid_pegawai", $uuid_profile)->count();
            $teraUlang = $teraUlang->join("pdp_data_petugas", "pdp_data_petugas.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")->where("pdp_data_petugas.uuid_pegawai", $uuid_profile)->count();
            $bdkt = $bdkt->join("pdp_data_petugas", "pdp_data_petugas.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")->where("pdp_data_petugas.uuid_pegawai", $uuid_profile)->count();
        } else {
            $tera = $tera->count();
            $teraUlang = $teraUlang->count();
            $bdkt = $bdkt->count();
        }

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

    // ScdStatistikTinjutMT
    public function ScdStatistikTinjutMT(Request $request)
    {
        // auth
        $auth = Auth::user();

        // get kelompok uttp
        $getKelompokUttpTera = MasterKelompokUttp::join("master_jenis_pelayanan", "master_jenis_pelayanan.uuid", "=", "master_kelompok_uttp.uuid_jenis_pelayanan")
            ->select("master_kelompok_uttp.*")
            ->where("master_jenis_pelayanan.nama_pelayanan", "Tera")
            ->where("master_kelompok_uttp.kode", "MT")
            ->firstOrFail();
        $uuid_kelompok_uttp_tera = $getKelompokUttpTera->uuid;
        $getKelompokUttpTulang = MasterKelompokUttp::join("master_jenis_pelayanan", "master_jenis_pelayanan.uuid", "=", "master_kelompok_uttp.uuid_jenis_pelayanan")
            ->select("master_kelompok_uttp.*")
            ->where("master_jenis_pelayanan.nama_pelayanan", "Tera Ulang")
            ->where("master_kelompok_uttp.kode", "MT")
            ->firstOrFail();
        $uuid_kelompok_uttp_tulang = $getKelompokUttpTulang->uuid;

        // request
        $tahun = $request->tahun;

        // hak akses
        $subRoleOnlyPetugas = CID::subRoleOnlyPetugas();
        if ($subRoleOnlyPetugas == true) {
            // hanya petugas
            $uuid_profile = $auth->uuid_profile;
            $tera = PdpPenjadwalan::join("pdp_data_petugas", "pdp_data_petugas.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")
                ->where("pdp_penjadwalan.uuid_kelompok_uttp", $uuid_kelompok_uttp_tera)
                ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
                ->whereIn("pdp_penjadwalan.status_peneraan", ["Diproses", "Selesai"])
                ->where("pdp_data_petugas.uuid_pegawai", $uuid_profile)
                ->count();
            $teraUlang = PdpPenjadwalan::join("pdp_data_petugas", "pdp_data_petugas.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")
                ->where("pdp_penjadwalan.uuid_kelompok_uttp", $uuid_kelompok_uttp_tulang)
                ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
                ->whereIn("pdp_penjadwalan.status_peneraan", ["Diproses", "Selesai"])
                ->where("pdp_data_petugas.uuid_pegawai", $uuid_profile)
                ->count();
        } else {
            $tera = PdpPenjadwalan::where("uuid_kelompok_uttp", $uuid_kelompok_uttp_tera)
                ->whereYear("tanggal_peneraan", $tahun)
                ->whereIn("status_peneraan", ["Diproses", "Selesai"])
                ->count();
            $teraUlang = PdpPenjadwalan::where("uuid_kelompok_uttp", $uuid_kelompok_uttp_tulang)
                ->whereYear("tanggal_peneraan", $tahun)
                ->whereIn("status_peneraan", ["Diproses", "Selesai"])
                ->count();
        }

        // data
        $data = [
            "jml_tera" => $tera,
            "jml_tera_ulang" => $teraUlang,
        ];

        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }

    // ScdStatistikTinjutUapv
    public function ScdStatistikTinjutUapv(Request $request)
    {
        // auth
        $auth = Auth::user();

        // get kelompok uttp
        $getKelompokUttpTera = MasterKelompokUttp::join("master_jenis_pelayanan", "master_jenis_pelayanan.uuid", "=", "master_kelompok_uttp.uuid_jenis_pelayanan")
            ->select("master_kelompok_uttp.*")
            ->where("master_jenis_pelayanan.nama_pelayanan", "Tera")
            ->where("master_kelompok_uttp.kode", "UAPV")
            ->firstOrFail();
        $uuid_kelompok_uttp_tera = $getKelompokUttpTera->uuid;
        $getKelompokUttpTulang = MasterKelompokUttp::join("master_jenis_pelayanan", "master_jenis_pelayanan.uuid", "=", "master_kelompok_uttp.uuid_jenis_pelayanan")
            ->select("master_kelompok_uttp.*")
            ->where("master_jenis_pelayanan.nama_pelayanan", "Tera Ulang")
            ->where("master_kelompok_uttp.kode", "UAPV")
            ->firstOrFail();
        $uuid_kelompok_uttp_tulang = $getKelompokUttpTulang->uuid;

        // request
        $tahun = $request->tahun;

        // hak akses
        $subRoleOnlyPetugas = CID::subRoleOnlyPetugas();
        if ($subRoleOnlyPetugas == true) {
            // hanya petugas
            $uuid_profile = $auth->uuid_profile;
            $tera = PdpPenjadwalan::join("pdp_data_petugas", "pdp_data_petugas.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")
                ->where("pdp_penjadwalan.uuid_kelompok_uttp", $uuid_kelompok_uttp_tera)
                ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
                ->whereIn("pdp_penjadwalan.status_peneraan", ["Diproses", "Selesai"])
                ->where("pdp_data_petugas.uuid_pegawai", $uuid_profile)
                ->count();
            $teraUlang = PdpPenjadwalan::join("pdp_data_petugas", "pdp_data_petugas.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")
                ->where("pdp_penjadwalan.uuid_kelompok_uttp", $uuid_kelompok_uttp_tulang)
                ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
                ->whereIn("pdp_penjadwalan.status_peneraan", ["Diproses", "Selesai"])
                ->where("pdp_data_petugas.uuid_pegawai", $uuid_profile)
                ->count();
        } else {
            $tera = PdpPenjadwalan::where("uuid_kelompok_uttp", $uuid_kelompok_uttp_tera)
                ->whereYear("tanggal_peneraan", $tahun)
                ->whereIn("status_peneraan", ["Diproses", "Selesai"])
                ->count();
            $teraUlang = PdpPenjadwalan::where("uuid_kelompok_uttp", $uuid_kelompok_uttp_tulang)
                ->whereYear("tanggal_peneraan", $tahun)
                ->whereIn("status_peneraan", ["Diproses", "Selesai"])
                ->count();
        }

        // data
        $data = [
            "jml_tera" => $tera,
            "jml_tera_ulang" => $teraUlang,
        ];

        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }

    // ScdStatistikTinjutBdkt
    public function ScdStatistikTinjutBdkt(Request $request)
    {
        // auth
        $auth = Auth::user();

        // get kelompok uttp
        $getKelompokUttpBdkt = MasterKelompokUttp::join("master_jenis_pelayanan", "master_jenis_pelayanan.uuid", "=", "master_kelompok_uttp.uuid_jenis_pelayanan")
            ->select("master_kelompok_uttp.*")
            ->where("master_jenis_pelayanan.nama_pelayanan", "Pengujian BDKT")
            ->where("master_kelompok_uttp.kode", "BDKT")
            ->firstOrFail();
        $uuid_kelompok_uttp_bdkt = $getKelompokUttpBdkt->uuid;

        // request
        $tahun = $request->tahun;

        // hak akses
        $subRoleOnlyPetugas = CID::subRoleOnlyPetugas();
        if ($subRoleOnlyPetugas == true) {
            // hanya petugas
            $uuid_profile = $auth->uuid_profile;
            $bdkt = PdpPenjadwalan::join("pdp_data_petugas", "pdp_data_petugas.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")
                ->where("pdp_penjadwalan.uuid_kelompok_uttp", $uuid_kelompok_uttp_bdkt)
                ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
                ->whereIn("pdp_penjadwalan.status_peneraan", ["Diproses", "Selesai"])
                ->where("pdp_data_petugas.uuid_pegawai", $uuid_profile)
                ->count();
        } else {
            $bdkt = PdpPenjadwalan::where("uuid_kelompok_uttp", $uuid_kelompok_uttp_bdkt)
                ->whereYear("tanggal_peneraan", $tahun)
                ->whereIn("status_peneraan", ["Diproses", "Selesai"])
                ->count();
        }

        // data
        $data = [
            "jml_bdkt" => $bdkt,
        ];

        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }

    // ScdTteDokumenSKHP
    public function ScdTteDokumenSKHP(Request $request)
    {
        // auth
        $auth = Auth::user();

        // request
        $tahun = $request->tahun;
        $tags = $request->tags;

        // hak akses
        $subRoleKetuaTimDanPimpinan = CID::subRoleKetuaTimDanPimpinan();
        if ($subRoleKetuaTimDanPimpinan == true) {
            // hanya petugas
            $uuid_profile = $auth->uuid_profile;
            $menunggu = PdpPenjadwalan::join("tte_skhp", "tte_skhp.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")
                ->join("permohonan_peneraan", "permohonan_peneraan.uuid", "=", "pdp_penjadwalan.uuid_permohonan")
                ->select("pdp_penjadwalan.*")
                ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
                ->where("pdp_penjadwalan.status_peneraan", "Selesai")
                ->where("tte_skhp.uuid_pejabat", $uuid_profile)
                ->where("tte_skhp.status_acc", "0")
                ->where("tte_skhp.file_skhp", "!=", null);
            $disetujui = PdpPenjadwalan::join("tte_skhp", "tte_skhp.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")
                ->join("permohonan_peneraan", "permohonan_peneraan.uuid", "=", "pdp_penjadwalan.uuid_permohonan")
                ->select("pdp_penjadwalan.*")
                ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
                ->where("pdp_penjadwalan.status_peneraan", "Selesai")
                ->where("tte_skhp.uuid_pejabat", $uuid_profile)
                ->where("tte_skhp.status_acc", "1")
                ->where("tte_skhp.file_skhp", "!=", null);
            $ditolak = PdpPenjadwalan::join("tte_skhp", "tte_skhp.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")
                ->join("permohonan_peneraan", "permohonan_peneraan.uuid", "=", "pdp_penjadwalan.uuid_permohonan")
                ->select("pdp_penjadwalan.*")
                ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
                ->where("pdp_penjadwalan.status_peneraan", "Selesai")
                ->where("tte_skhp.uuid_pejabat", $uuid_profile)
                ->where("tte_skhp.status_acc", "2")
                ->where("tte_skhp.file_skhp", "!=", null);
        } else {
            $menunggu = PdpPenjadwalan::join("tte_skhp", "tte_skhp.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")
                ->join("permohonan_peneraan", "permohonan_peneraan.uuid", "=", "pdp_penjadwalan.uuid_permohonan")
                ->select("pdp_penjadwalan.*")
                ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
                ->where("pdp_penjadwalan.status_peneraan", "Selesai")
                ->where("tte_skhp.status_acc", "0")
                ->where("tte_skhp.file_skhp", "!=", null);
            $disetujui = PdpPenjadwalan::join("tte_skhp", "tte_skhp.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")
                ->join("permohonan_peneraan", "permohonan_peneraan.uuid", "=", "pdp_penjadwalan.uuid_permohonan")
                ->select("pdp_penjadwalan.*")
                ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
                ->where("pdp_penjadwalan.status_peneraan", "Selesai")
                ->where("tte_skhp.status_acc", "1")
                ->where("tte_skhp.file_skhp", "!=", null);
            $ditolak = PdpPenjadwalan::join("tte_skhp", "tte_skhp.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")
                ->join("permohonan_peneraan", "permohonan_peneraan.uuid", "=", "pdp_penjadwalan.uuid_permohonan")
                ->select("pdp_penjadwalan.*")
                ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
                ->where("pdp_penjadwalan.status_peneraan", "Selesai")
                ->where("tte_skhp.status_acc", "2")
                ->where("tte_skhp.file_skhp", "!=", null);
        }

        // cek tags
        if ($tags == "All") {
            $menunggu = $menunggu->count();
            $disetujui = $disetujui->count();
            $ditolak = $ditolak->count();
        } else {
            $menunggu = $menunggu->where("permohonan_peneraan.jenis_pengujian", $tags)->count();
            $disetujui = $disetujui->where("permohonan_peneraan.jenis_pengujian", $tags)->count();
            $ditolak = $ditolak->where("permohonan_peneraan.jenis_pengujian", $tags)->count();
        }

        // data
        $data = [
            "jml_menunggu" => $menunggu,
            "jml_disetujui" => $disetujui,
            "jml_ditolak" => $ditolak,
        ];

        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }

    // SetGetTtePejabat
    public function SetGetTtePejabat(Request $request)
    {
        // uuid jabatan
        $jabatan = $request->jabatan;
        if ($jabatan == "Kepala Dinas") {
            $data = Pegawai::join("users", "users.uuid_profile", "=", "pegawai.uuid")
                ->select("pegawai.*", "users.role", "users.sub_role", "users.sub_sub_role", "users.status", "users.uuid as uuid_user")
                ->where("users.role", "Kepala Dinas")
                ->where("users.status", "1")
                ->orderBy("pegawai.nama_lengkap", "ASC")
                ->get();
        } elseif ($jabatan == "Kepala Bidang") {
            $data = Pegawai::join("users", "users.uuid_profile", "=", "pegawai.uuid")
                ->select("pegawai.*", "users.role", "users.sub_role", "users.sub_sub_role", "users.status", "users.uuid as uuid_user")
                ->where("users.role", "Kepala Bidang")
                ->where("users.status", "1")
                ->orderBy("pegawai.nama_lengkap", "ASC")
                ->get();
        } elseif ($jabatan == "Ketua Tim") {
            $data = Pegawai::join("users", "users.uuid_profile", "=", "pegawai.uuid")
                ->select("pegawai.*", "users.role", "users.sub_role", "users.sub_sub_role", "users.status", "users.uuid as uuid_user")
                ->where("users.role", "Pegawai")
                ->where("users.sub_role", 'LIKE', '%Ketua Tim%')
                ->where("users.sub_sub_role", 'LIKE', '%Ketua Tim Pelayanan%')
                ->where("users.status", "1")
                ->orderBy("pegawai.nama_lengkap", "ASC")
                ->get();
        } else {
            // response
            $response = [
                "status" => false,
                "message" => "Data Jabatan Tidak Valid!",
            ];
            return response()->json($response, 422);
        }

        // response
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }
}
