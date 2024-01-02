<?php

namespace App\Http\Controllers\ApiBase\ApiAdmin\PdpApps\retribusi;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PdpRetribusi;
use App\Models\PermohonanPeneraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiPDPRetribusiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // auth
        $auth = auth()->user();
        $profile = $auth->RelPerusahaan;

        $dataRetribusi = PermohonanPeneraan::join("pdp_penjadwalan", "pdp_penjadwalan.uuid_permohonan", "=", "permohonan_peneraan.uuid")
            ->join("pdp_retribusi", "pdp_retribusi.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")
            ->select("permohonan_peneraan.*")
            ->with('RelPerusahaan')
            ->with('RelPdpPenjadwalan')
            ->with('RelPdpPenjadwalan.RelPdpRetribusi')
            ->where("permohonan_peneraan.uuid_perusahaan", $profile->uuid)
            ->where("pdp_retribusi.kode_bayar_webr", "!=", null)
            ->orderBy("pdp_retribusi.tgl_skrd", "DESC")
            ->get();

        if (count($dataRetribusi) > 0) {
            $data = [];
            foreach ($dataRetribusi as $item) {
                $urlPrintSkrd = route('print.pdp.skrd', [CID::encode($item->RelPdpPenjadwalan->uuid)]);
                $data[] = $item;
                $item->print_skrd = $urlPrintSkrd;
            }
        } else {
            $data = $dataRetribusi;
        }

        // response
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $uuid)
    {
        // auth
        $auth = auth()->user();
        $profile = $auth->RelPerusahaan;
        $uuid_profile = $auth->uuid_profile;
        $uuid_perusahaan = $profile->uuid;

        // uuid
        $data = PdpRetribusi::findOrFail($uuid);
        $kode_permohonan = $data->RelPdpPenjadwalan->RelPermohonanPeneraan->kode_permohonan;

        // validate
        $validator = Validator::make($request->all(), [
            "file_pembayaran" => "required|file|mimes:png,jpg,jpeg,pdf|max:5000",
        ]);

        // response validasi
        $response = [
            "status" => false,
            "message" => "Validation Error!!",
            "errors" => $validator->errors(),
            "request" => $request->all(),
        ];
        if ($validator->fails()) {
            return response()->json($response, 422);
        }

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
                $response = [
                    "status" => false,
                    "message" => "Gagal Menyimpan Data, File Bukti Pembayaran Tidak Sesuai Format!",
                    "request" => $request->all(),
                ];
                return response()->json($response, 422);
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
                "role" => "Perusahaan",
                "device" => "mobile",
                "dashboard" => "1",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            $response = [
                "status" => true,
                "message" => 'Berhasil Mengupload Bukti Bayar Retribusi.',
            ];
            return response()->json($response, 201);
        } else {
            $response = [
                "status" => false,
                "message" => 'Gagal Mengupload Bukti Bayar Retribusi.',
                "request" => $request->all(),
            ];
            return response()->json($response, 422);
        }
    }
}