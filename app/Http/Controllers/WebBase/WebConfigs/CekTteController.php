<?php

namespace App\Http\Controllers\WebBase\WebConfigs;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PdpPenjadwalan;
use App\Models\TteSkhp;
use Illuminate\Support\Facades\Cache;

class CekTteController extends Controller
{
    //indexSkhp
    public function indexSkhp($kode_tte)
    {
        // background
        $pageBg = Cache::get('pageBg');
        if ($pageBg === null) {
            $bgNumber = rand(1, 31);
            // Cache::put('pageBg', $bgNumber, now()->addHours(24));
            Cache::put('pageBg', $bgNumber, now()->addMinutes(1));
            $pageBg = $bgNumber;
        } else {
            $pageBg = $pageBg;
        }

        // data
        $data = TteSkhp::where("kode_tte", $kode_tte)->first();
        if ($data === null) {
            $title = "404 - Dokumen Tidak Ditemukan";
            return \view('pages.tte.invalid', compact(
                'kode_tte',
                'pageBg',
                'title',
            ));
        } else {
            if ($data->status_aktif == "0") {
                $title = "404 - Dokumen Tidak Ditemukan";
                return \view('pages.tte.invalid', compact(
                    'kode_tte',
                    'pageBg',
                    'title',
                ));
            }

            $pdp = $data->RelPdpPenjadwalan;
            $permohonan = $pdp->RelPermohonanPeneraan;
            $perusahaan = $permohonan->RelPerusahaan;
            $RelAlamat = $permohonan->RelAlamatPerusahaan;
            $jp = $permohonan->jenis_pengujian;
            $tte = $data;
            $title = "SKHP - Nomor Order: " . $data->nomor_order;
            return \view('pages.tte.skhp', compact(
                'kode_tte',
                'pageBg',
                'title',
                'data',
                'pdp',
                'permohonan',
                'perusahaan',
                'RelAlamat',
                'jp',
                'tte',
            ));
        }
    }

    //indexSkrd
    public function indexSkrd($enc_uuid)
    {
        // background
        $pageBg = Cache::get('pageBg');
        if ($pageBg === null) {
            $bgNumber = rand(1, 31);
            // Cache::put('pageBg', $bgNumber, now()->addHours(24));
            Cache::put('pageBg', $bgNumber, now()->addMinutes(1));
            $pageBg = $bgNumber;
        } else {
            $pageBg = $pageBg;
        }

        // uuid
        $uuid = CID::decode($enc_uuid);

        // data
        $data = PdpPenjadwalan::find($uuid);
        if ($data === null) {
            $title = "404 - Dokumen Tidak Ditemukan";
            return \view('pages.tte.invalid', compact(
                'enc_uuid',
                'pageBg',
                'title',
            ));
        } else {
            $permohonan = $data->RelPermohonanPeneraan;
            $perusahaan = $permohonan->RelPerusahaan;
            $alamat_peneraan = $permohonan->RelAlamatPerusahaan;
            $jenis_pengujian = $permohonan->jenis_pengujian;
            $alamatDefault = $perusahaan->RelAlamatPerusahaanDefault[0];
            $retribusi = $data->RelPdpRetribusi;
            $title = "SKRD - Nomor Order: " . $data->nomor_order;
            return \view('pages.tte.skrd', compact(
                'enc_uuid',
                'pageBg',
                'title',
                'data',
                'permohonan',
                'perusahaan',
                'alamatDefault',
                'alamat_peneraan',
                'jenis_pengujian',
                'retribusi',
            ));
        }
    }
}
