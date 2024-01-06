<?php

namespace App\Http\Controllers\ApiBase\ApiAdmin\ScheduleApps\tinjut\action;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PdpFileCerapan;
use App\Models\PdpPenjadwalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiScdTinjutActionCerapanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($uuid_pdp)
    {
        // Data Penjadwalan dan Penugasan
        $dataPdp = PdpPenjadwalan::findOrFail($uuid_pdp);
        $dataPdp->RelFileCerapan;

        // response
        $response = [
            "status" => true,
            "data" => $dataPdp,
        ];
        return response()->json($response, 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $uuid_pdp)
    {
        // auth
        $auth = auth()->user();
        $uuid = $uuid_pdp;

        // data
        $dataPdp = PdpPenjadwalan::findOrFail($uuid);

        // cek status permohonan
        if ($dataPdp->RelPermohonanPeneraan->status == "Selesai") {
            // response
            $response = [
                "status" => false,
                "message" => "Status Permohonan Sudah Selesai!",
                "request" => $request->all(),
            ];
            return response()->json($response, 422);
        }

        // validate
        $validator = Validator::make($request->all(), [
            "jenis_cerapan" => "required|string|max:300",
            "keterangan" => "sometimes|nullable|string|max:1000",
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

        // cek create atau update
        if ($request->uuid_update === null) {
            // create
            // value_1
            $uuid_cerapan = Str::uuid();
            $jenis_cerapan = $request->jenis_cerapan;
            $keterangan = $request->keterangan;
            $value_1 = [
                "uuid" => $uuid_cerapan,
                "uuid_penjadwalan" => $uuid,
                "jenis_cerapan" => $jenis_cerapan,
                "keterangan" => nl2br($keterangan),
                "uuid_created" => $auth->uuid_profile,
            ];
            // file_cerapan
            $nomor_order = Str::slug($dataPdp->nomor_order);
            $path = "file_cerapan/" . date('Y', strtotime($dataPdp->tanggal_peneraan)) . "/" . $nomor_order;
            if ($request->hasFile('file_cerapan')) {
                // validate
                $validator = Validator::make($request->all(), [
                    "file_cerapan" => "required|file|mimes:pdf|max:50000",
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

                $file_cerapan = CID::UpFilePdf($request, "file_cerapan", $path);
                if ($file_cerapan == "0") {
                    // response
                    $response = [
                        "status" => false,
                        "message" => "Gagal Menyimpan Data, File Cerapan Tidak Sesuai Format!",
                        "request" => $request->all(),
                    ];
                    return response()->json($response, 422);
                }
                $value_1['file_cerapan'] = $file_cerapan['url'];
                $value_1['tipe'] = $file_cerapan['tipe_file'];
                $value_1['size'] = $file_cerapan['ukuran_file'];
            }
            // save
            $save_1 = PdpFileCerapan::create($value_1);
            if ($save_1) {
                // create log
                $aktifitas = [
                    "tabel" => array("pdp_file_cerapan"),
                    "uuid" => array($uuid_cerapan),
                    "value" => array($value_1),
                ];
                $log = [
                    "apps" => "Schedule Apps",
                    "subjek" => "Upload File Cerapan : " . $jenis_cerapan . " - " . $uuid_cerapan,
                    "aktifitas" => $aktifitas,
                    "role" => $auth->role,
                    "device" => "mobile",
                    "dashboard" => "1",
                ];
                CID::addToLogAktifitas($request, $log);
                // alert success
                $response = [
                    "status" => true,
                    "message" => "Berhasil Upload File Cerapan : " . $jenis_cerapan . " - " . $uuid_cerapan,
                ];
                return response()->json($response, 200);
            } else {
                $response = [
                    "status" => false,
                    "message" => "Berhasil Upload File Cerapan : " . $jenis_cerapan . " - " . $uuid_cerapan,
                    "request" => $request->all(),
                ];
                return response()->json($response, 422);
            }
        } else {
            // update
            // value_1
            $uuid_cerapan = $request->uuid_update;
            // cek file cerapan
            $dataCerapan = PdpFileCerapan::findOrFail($uuid_cerapan);
            $jenis_cerapan = $request->jenis_cerapan;
            $keterangan = $request->keterangan;
            $value_1 = [
                "jenis_cerapan" => $jenis_cerapan,
                "keterangan" => nl2br($keterangan),
                "uuid_updated" => $auth->uuid_profile,
            ];
            // file_cerapan
            $nomor_order = Str::slug($dataPdp->nomor_order);
            $path = "file_cerapan/" . date('Y', strtotime($dataPdp->tanggal_peneraan)) . "/" . $nomor_order;
            if ($request->hasFile('file_cerapan')) {
                // validate
                $validator = Validator::make($request->all(), [
                    "file_cerapan" => "required|file|mimes:pdf|max:50000",
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

                if ($dataCerapan->file_cerapan !== null) {
                    $file_cerapan_unlik = $dataCerapan->file_cerapan;
                    if (Storage::disk('public')->exists($file_cerapan_unlik)) {
                        unlink(storage_path('app/public/' . $file_cerapan_unlik));
                    }
                }

                $file_cerapan = CID::UpFilePdf($request, "file_cerapan", $path);
                if ($file_cerapan == "0") {
                    // response
                    $response = [
                        "status" => false,
                        "message" => "Gagal Menyimpan Data, File Cerapan Tidak Sesuai Format!",
                        "request" => $request->all(),
                    ];
                    return response()->json($response, 422);
                }
                $value_1['file_cerapan'] = $file_cerapan['url'];
                $value_1['tipe'] = $file_cerapan['tipe_file'];
                $value_1['size'] = $file_cerapan['ukuran_file'];
            }
            // save
            $save_1 = $dataCerapan->update($value_1);
            if ($save_1) {
                // create log
                $aktifitas = [
                    "tabel" => array("pdp_file_cerapan"),
                    "uuid" => array($uuid_cerapan),
                    "value" => array($value_1),
                ];
                $log = [
                    "apps" => "Schedule Apps",
                    "subjek" => "Update File Cerapan : " . $jenis_cerapan . " - " . $uuid_cerapan,
                    "aktifitas" => $aktifitas,
                    "role" => $auth->role,
                    "device" => "mobile",
                    "dashboard" => "1",
                ];
                CID::addToLogAktifitas($request, $log);
                // alert success
                $response = [
                    "status" => true,
                    "message" => "Berhasil Update File Cerapan : " . $jenis_cerapan . " - " . $uuid_cerapan,
                ];
                return response()->json($response, 200);
            } else {
                $response = [
                    "status" => false,
                    "message" => "Berhasil Update File Cerapan : " . $jenis_cerapan . " - " . $uuid_cerapan,
                    "request" => $request->all(),
                ];
                return response()->json($response, 422);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($uuid_pdp, $uuid)
    {
        // Data Penjadwalan dan Penugasan
        $dataPdp = PdpPenjadwalan::findOrFail($uuid_pdp);
        $dataPdp->RelFileCerapan;

        // data file cerapan
        $dataFileCerapan = PdpFileCerapan::findOrFail($uuid);

        // response
        $response = [
            "status" => true,
            "data" => $dataFileCerapan,
        ];
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $uuid_pdp)
    {
        // auth
        $auth = auth()->user();

        // Data Penjadwalan dan Penugasan
        $dataPdp = PdpPenjadwalan::findOrFail($uuid_pdp);
        $dataPdp->RelFileCerapan;

        // uuid
        $uuid = $request->uuid;

        // data
        $data = PdpFileCerapan::findOrFail($uuid);

        // cek ACC
        if ($data->RelPdpPenjadwalan->PdpPermohonanPeneraan == "Selesai") {
            // success
            $msg = "Data Gagal Dihapus, Status Permohonan Peneraan Sudah Selesai!";
            $response = [
                "status" => false,
                "message" => $msg,
            ];
            return response()->json($response, 422);
        }

        // delete file
        // if ($data->file_cerapan !== null) {
        //     $file_cerapan_unlik = $data->file_cerapan;
        //     if (Storage::disk('public')->exists($file_cerapan_unlik)) {
        //         unlink(storage_path('app/public/' . $file_cerapan_unlik));
        //     }
        // }

        // save
        // $save_1 = $data->forceDelete();
        $save_1 = $data->delete();
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("pdp_file_cerapan"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Schedule Apps",
                "subjek" => "Berhasil Menghapus File Cerapan: " . $data->jenis_cerapan . " - " . $uuid,
                "aktifitas" => $aktifitas,
                "role" => $auth->role,
                "device" => "mobile",
                "dashboard" => "1",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            $msg = "Data Berhasil Dihapus!";
            $response = [
                "status" => true,
                "message" => $msg,
            ];
            return response()->json($response, 200);
        } else {
            // success
            $msg = "Data Gagal Dihapus!";
            $response = [
                "status" => false,
                "message" => $msg,
            ];
            return response()->json($response, 422);
        }
    }
}
