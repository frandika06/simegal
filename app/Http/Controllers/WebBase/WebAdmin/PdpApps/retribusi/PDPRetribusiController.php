<?php

namespace App\Http\Controllers\WebBase\WebAdmin\PdpApps\retribusi;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PdpRetribusi;
use App\Models\PermohonanPeneraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PDPRetribusiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // auth
        $auth = Auth::user();
        $profile = $auth->RelPerusahaan;

        $dataRetribusi = PermohonanPeneraan::join("pdp_penjadwalan", "pdp_penjadwalan.uuid_permohonan", "=", "permohonan_peneraan.uuid")
            ->join("pdp_retribusi", "pdp_retribusi.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")
            ->select("permohonan_peneraan.*")
            ->with('RelPerusahaan')
            ->with('RelPdpPenjadwalan')
            ->with('RelPdpPenjadwalan.RelPdpRetribusi')
            ->where("permohonan_peneraan.uuid_perusahaan", $profile->uuid)
            ->orderBy("pdp_retribusi.tgl_skrd", "DESC")
            ->get();

        return view('pages.admin.pdp_apps.retribusi.index', compact(
            'profile',
            'dataRetribusi',
        ));
    }

    /**
     * Display a listing of the resource.
     */
    public function create(Request $request, $enc_uuid)
    {
        // auth
        $auth = Auth::user();
        $profile = $auth->RelPerusahaan;

        // uuid
        $uuid = CID::decode($enc_uuid);
        $data = PdpRetribusi::findOrFail($uuid);

        // title & button
        $title = "Upload Bukti Bayar";
        $submit = "Simpan";
        return view('pages.admin.pdp_apps.retribusi.upload', compact(
            'enc_uuid',
            'title',
            'submit',
            'profile',
            'data',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $enc_uuid)
    {
        // auth
        $auth = Auth::user();
        $profile = $auth->RelPerusahaan;
        $uuid_profile = $auth->uuid_profile;
        $uuid_perusahaan = $profile->uuid;

        // uuid
        $uuid = CID::decode($enc_uuid);
        $data = PdpRetribusi::findOrFail($uuid);
        $kode_permohonan = $data->RelPdpPenjadwalan->RelPermohonanPeneraan->kode_permohonan;

        // validate
        $request->validate([
            "file_pembayaran" => "required|file|mimes:png,jpg,jpeg,pdf|max:5000",
        ]);

        // value
        $value_1 = [
            "tgl_upload" => date('Y-m-d H:i:s'),
            "uuid_updated" => $uuid_profile,
        ];

        // file_pembayaran
        $path = "permohonan/" . date('Y') . "/" . $kode_permohonan;
        if ($request->hasFile('file_pembayaran')) {
            if ($data->file_pembayaran !== null) {
                unlink(storage_path('app/public/' . $data->file_pembayaran));
            }
            $file_pembayaran = CID::UpImgPdf($request, "file_pembayaran", $path);
            if ($file_pembayaran == "0") {
                alert()->error('Error!', 'Gagal Menyimpan Data, File Surat Permohonan Tidak Sesuai Format!');
                return \back();
            }
            $value_1['file_pembayaran'] = $file_pembayaran['url'];
        }

        // save
        $save_1 = $data->update($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("pdp_retribusi"),
                "uuid" => array($uuid),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Penjadwalan dan Penugasan Apps",
                "subjek" => "Berhasil Mengupload Bukti Bayar Retribusi (" . $kode_permohonan . ") - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "1",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Berhasil!', 'Berhasil Mengupload Bukti Bayar Retribusi.');
            return redirect()->route('pdp.apps.retribusi.index');
        } else {
            alert()->error('Gagal!', 'Gagal Mengupload Bukti Bayar Retribusi.');
            return back()->withInput($request->all());
        }
    }

}