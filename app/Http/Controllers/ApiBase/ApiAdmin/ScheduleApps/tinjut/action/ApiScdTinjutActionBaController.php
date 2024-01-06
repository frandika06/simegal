<?php

namespace App\Http\Controllers\ApiBase\ApiAdmin\ScheduleApps\tinjut\action;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PdpFileBa;
use App\Models\PdpPenjadwalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiScdTinjutActionBaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($uuid_pdp)
    {
        // Data Penjadwalan dan Penugasan
        $dataPdp = PdpPenjadwalan::findOrFail($uuid_pdp);
        $dataPdp->RelFileBa;

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
            "jenis_ba" => "required|string|max:300",
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
            $uuid_ba = Str::uuid();
            $jenis_ba = $request->jenis_ba;
            $keterangan = $request->keterangan;
            $value_1 = [
                "uuid" => $uuid_ba,
                "uuid_penjadwalan" => $uuid,
                "jenis_ba" => $jenis_ba,
                "keterangan" => nl2br($keterangan),
                "uuid_created" => $auth->uuid_profile,
            ];
            // file_ba
            $nomor_order = Str::slug($dataPdp->nomor_order);
            $path = "file_ba/" . date('Y', strtotime($dataPdp->tanggal_peneraan)) . "/" . $nomor_order;
            if ($request->hasFile('file_ba')) {
                // validate
                $validator = Validator::make($request->all(), [
                    "file_ba" => "required|file|mimes:pdf|max:50000",
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

                $file_ba = CID::UpFilePdf($request, "file_ba", $path);
                if ($file_ba == "0") {
                    // response
                    $response = [
                        "status" => false,
                        "message" => "Gagal Menyimpan Data, File BA Tidak Sesuai Format!",
                        "request" => $request->all(),
                    ];
                    return response()->json($response, 422);
                }
                $value_1['file_ba'] = $file_ba['url'];
                $value_1['tipe'] = $file_ba['tipe_file'];
                $value_1['size'] = $file_ba['ukuran_file'];
            }
            // save
            $save_1 = PdpFileBa::create($value_1);
            if ($save_1) {
                // create log
                $aktifitas = [
                    "tabel" => array("pdp_file_ba"),
                    "uuid" => array($uuid_ba),
                    "value" => array($value_1),
                ];
                $log = [
                    "apps" => "Schedule Apps",
                    "subjek" => "Upload File BA : " . $jenis_ba . " - " . $uuid_ba,
                    "aktifitas" => $aktifitas,
                    "role" => $auth->role,
                    "device" => "mobile",
                    "dashboard" => "1",
                ];
                CID::addToLogAktifitas($request, $log);
                // alert success
                $response = [
                    "status" => true,
                    "message" => "Berhasil Upload File BA : " . $jenis_ba . " - " . $uuid_ba,
                ];
                return response()->json($response, 200);
            } else {
                $response = [
                    "status" => false,
                    "message" => "Berhasil Upload File BA : " . $jenis_ba . " - " . $uuid_ba,
                    "request" => $request->all(),
                ];
                return response()->json($response, 422);
            }
        } else {
            // update
            // value_1
            $uuid_ba = $request->uuid_update;
            // cek file BA
            $dataBa = PdpFileBa::findOrFail($uuid_ba);
            $jenis_ba = $request->jenis_ba;
            $keterangan = $request->keterangan;
            $value_1 = [
                "jenis_ba" => $jenis_ba,
                "keterangan" => nl2br($keterangan),
                "uuid_updated" => $auth->uuid_profile,
            ];
            // file_ba
            $nomor_order = Str::slug($dataPdp->nomor_order);
            $path = "file_ba/" . date('Y', strtotime($dataPdp->tanggal_peneraan)) . "/" . $nomor_order;
            if ($request->hasFile('file_ba')) {
                // validate
                $validator = Validator::make($request->all(), [
                    "file_ba" => "required|file|mimes:pdf|max:50000",
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

                if ($dataBa->file_ba !== null) {
                    $file_ba_unlik = $dataBa->file_ba;
                    if (Storage::disk('public')->exists($file_ba_unlik)) {
                        unlink(storage_path('app/public/' . $file_ba_unlik));
                    }
                }

                $file_ba = CID::UpFilePdf($request, "file_ba", $path);
                if ($file_ba == "0") {
                    // response
                    $response = [
                        "status" => false,
                        "message" => "Gagal Menyimpan Data, File BA Tidak Sesuai Format!",
                        "request" => $request->all(),
                    ];
                    return response()->json($response, 422);
                }
                $value_1['file_ba'] = $file_ba['url'];
                $value_1['tipe'] = $file_ba['tipe_file'];
                $value_1['size'] = $file_ba['ukuran_file'];
            }
            // save
            $save_1 = $dataBa->update($value_1);
            if ($save_1) {
                // create log
                $aktifitas = [
                    "tabel" => array("pdp_file_ba"),
                    "uuid" => array($uuid_ba),
                    "value" => array($value_1),
                ];
                $log = [
                    "apps" => "Schedule Apps",
                    "subjek" => "Update File BA : " . $jenis_ba . " - " . $uuid_ba,
                    "aktifitas" => $aktifitas,
                    "role" => $auth->role,
                    "device" => "mobile",
                    "dashboard" => "1",
                ];
                CID::addToLogAktifitas($request, $log);
                // alert success
                $response = [
                    "status" => true,
                    "message" => "Berhasil Update File BA : " . $jenis_ba . " - " . $uuid_ba,
                ];
                return response()->json($response, 200);
            } else {
                $response = [
                    "status" => false,
                    "message" => "Berhasil Update File BA : " . $jenis_ba . " - " . $uuid_ba,
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
        $dataPdp->RelFileBa;

        // data file BA
        $dataFileBa = PdpFileBa::findOrFail($uuid);

        // response
        $response = [
            "status" => true,
            "data" => $dataFileBa,
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
        $dataPdp->RelFileBa;

        // uuid
        $uuid = $request->uuid;

        // data
        $data = PdpFileBa::findOrFail($uuid);

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
        // if ($data->file_ba !== null) {
        //     $file_ba_unlik = $data->file_ba;
        //     if (Storage::disk('public')->exists($file_ba_unlik)) {
        //         unlink(storage_path('app/public/' . $file_ba_unlik));
        //     }
        // }

        // save
        // $save_1 = $data->forceDelete();
        $save_1 = $data->delete();
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("pdp_file_ba"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Schedule Apps",
                "subjek" => "Berhasil Menghapus File BA: " . $data->jenis_ba . " - " . $uuid,
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
