<?php

namespace App\Http\Controllers\WebBase\WebConfigs;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PdpPenjadwalan;
use Illuminate\Http\Request;

class PrintPdpController extends Controller
{
    //suratJalan
    public function suratJalan(Request $request, $enc_uuid)
    {
        // uuid
        $uuid = CID::decode($enc_uuid);

        // data
        $data = PdpPenjadwalan::findOrFail($uuid);
        $permohonan = $data->RelPermohonanPeneraan;
        $perusahaan = $permohonan->RelPerusahaan;
        $alamat_peneraan = $permohonan->RelAlamatPerusahaan;
        $jenis_pengujian = $permohonan->jenis_pengujian;

        return view('pages.print.pdp.surat_jalan', compact(
            'data',
            'permohonan',
            'perusahaan',
            'alamat_peneraan',
            'jenis_pengujian',
        ));
    }

    //suratPerintah
    public function suratPerintah(Request $request, $enc_uuid)
    {
        // uuid
        $uuid = CID::decode($enc_uuid);

        // data
        $data = PdpPenjadwalan::findOrFail($uuid);
        $permohonan = $data->RelPermohonanPeneraan;
        $perusahaan = $permohonan->RelPerusahaan;
        $alamat_peneraan = $permohonan->RelAlamatPerusahaan;
        $jenis_pengujian = $permohonan->jenis_pengujian;

        return view('pages.print.pdp.surat_perintah', compact(
            'data',
            'permohonan',
            'perusahaan',
            'alamat_peneraan',
            'jenis_pengujian',
        ));
    }

    //kartuPenerusDisposisi
    public function kartuPenerusDisposisi(Request $request, $enc_uuid)
    {
        // uuid
        $uuid = CID::decode($enc_uuid);

        // data
        $data = PdpPenjadwalan::findOrFail($uuid);
        $permohonan = $data->RelPermohonanPeneraan;
        $perusahaan = $permohonan->RelPerusahaan;
        $alamat_peneraan = $permohonan->RelAlamatPerusahaan;
        $jenis_pengujian = $permohonan->jenis_pengujian;
        $alamatDefault = $perusahaan->RelAlamatPerusahaanDefault[0];

        return view('pages.print.pdp.surat_disposisi', compact(
            'data',
            'permohonan',
            'perusahaan',
            'alamatDefault',
            'alamat_peneraan',
            'jenis_pengujian',
        ));
    }
}
