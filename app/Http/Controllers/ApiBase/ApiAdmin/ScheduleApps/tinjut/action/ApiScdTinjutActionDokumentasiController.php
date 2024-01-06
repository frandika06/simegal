<?php

namespace App\Http\Controllers\ApiBase\ApiAdmin\ScheduleApps\tinjut\action;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PdpFileDokumentasi;
use App\Models\PdpPenjadwalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiScdTinjutActionDokumentasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($uuid_pdp)
    {
        // Data Penjadwalan dan Penugasan
        $dataPdp = PdpPenjadwalan::findOrFail($uuid_pdp);
        $dataPdp->RelFileDokumentasi;

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
            "nama_dokumentasi" => "required|string|max:300",
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
            $uuid_dokumentasi = Str::uuid();
            $nama_dokumentasi = $request->nama_dokumentasi;
            $value_1 = [
                "uuid" => $uuid_dokumentasi,
                "uuid_penjadwalan" => $uuid,
                "nama_dokumentasi" => $nama_dokumentasi,
                "uuid_created" => $auth->uuid_profile,
            ];
            // file_dokumentasi
            $nomor_order = Str::slug($dataPdp->nomor_order);
            $path = "file_dokumentasi/" . date('Y', strtotime($dataPdp->tanggal_peneraan)) . "/" . $nomor_order;
            if ($request->hasFile('file_dokumentasi')) {
                // validate
                $validator = Validator::make($request->all(), [
                    "file_dokumentasi" => "required|image|mimes:png,jpg,jpeg|max:50000",
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

                $file_dokumentasi = CID::UpImgPdf($request, "file_dokumentasi", $path);
                if ($file_dokumentasi == "0") {
                    // response
                    $response = [
                        "status" => false,
                        "message" => "Gagal Menyimpan Data, File Dokumentasi Tidak Sesuai Format!",
                        "request" => $request->all(),
                    ];
                    return response()->json($response, 422);
                }
                $value_1['file_dokumentasi'] = $file_dokumentasi['url'];
                $value_1['tipe'] = $file_dokumentasi['tipe_file'];
                $value_1['size'] = $file_dokumentasi['ukuran_file'];
            }
            // save
            $save_1 = PdpFileDokumentasi::create($value_1);
            if ($save_1) {
                // create log
                $aktifitas = [
                    "tabel" => array("pdp_file_dokumentasi"),
                    "uuid" => array($uuid_dokumentasi),
                    "value" => array($value_1),
                ];
                $log = [
                    "apps" => "Schedule Apps",
                    "subjek" => "Upload File Dokumentasi : " . $nama_dokumentasi . " - " . $uuid_dokumentasi,
                    "aktifitas" => $aktifitas,
                    "role" => $auth->role,
                    "device" => "mobile",
                    "dashboard" => "1",
                ];
                CID::addToLogAktifitas($request, $log);
                // alert success
                $response = [
                    "status" => true,
                    "message" => "Berhasil Upload File Dokumentasi : " . $nama_dokumentasi . " - " . $uuid_dokumentasi,
                ];
                return response()->json($response, 200);
            } else {
                $response = [
                    "status" => false,
                    "message" => "Berhasil Upload File Dokumentasi : " . $nama_dokumentasi . " - " . $uuid_dokumentasi,
                    "request" => $request->all(),
                ];
                return response()->json($response, 422);
            }
        } else {
            // update
            // value_1
            $uuid_dokumentasi = $request->uuid_update;
            // cek file Dokumentasi
            $dataDokumentasi = PdpFileDokumentasi::findOrFail($uuid_dokumentasi);
            $nama_dokumentasi = $request->nama_dokumentasi;
            $value_1 = [
                "nama_dokumentasi" => $nama_dokumentasi,
                "uuid_updated" => $auth->uuid_profile,
            ];
            // file_dokumentasi
            $nomor_order = Str::slug($dataPdp->nomor_order);
            $path = "file_dokumentasi/" . date('Y', strtotime($dataPdp->tanggal_peneraan)) . "/" . $nomor_order;
            if ($request->hasFile('file_dokumentasi')) {
                // validate
                $validator = Validator::make($request->all(), [
                    "file_dokumentasi" => "required|image|mimes:png,jpg,jpeg|max:50000",
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

                if ($dataDokumentasi->file_dokumentasi !== null) {
                    $file_dokumentasi_unlik = $dataDokumentasi->file_dokumentasi;
                    if (Storage::disk('public')->exists($file_dokumentasi_unlik)) {
                        unlink(storage_path('app/public/' . $file_dokumentasi_unlik));
                    }
                }

                $file_dokumentasi = CID::UpImgPdf($request, "file_dokumentasi", $path);
                if ($file_dokumentasi == "0") {
                    // response
                    $response = [
                        "status" => false,
                        "message" => "Gagal Menyimpan Data, File Dokumentasi Tidak Sesuai Format!",
                        "request" => $request->all(),
                    ];
                    return response()->json($response, 422);
                }
                $value_1['file_dokumentasi'] = $file_dokumentasi['url'];
                $value_1['tipe'] = $file_dokumentasi['tipe_file'];
                $value_1['size'] = $file_dokumentasi['ukuran_file'];
            }
            // save
            $save_1 = $dataDokumentasi->update($value_1);
            if ($save_1) {
                // create log
                $aktifitas = [
                    "tabel" => array("pdp_file_dokumentasi"),
                    "uuid" => array($uuid_dokumentasi),
                    "value" => array($value_1),
                ];
                $log = [
                    "apps" => "Schedule Apps",
                    "subjek" => "Update File Dokumentasi : " . $nama_dokumentasi . " - " . $uuid_dokumentasi,
                    "aktifitas" => $aktifitas,
                    "role" => $auth->role,
                    "device" => "mobile",
                    "dashboard" => "1",
                ];
                CID::addToLogAktifitas($request, $log);
                // alert success
                $response = [
                    "status" => true,
                    "message" => "Berhasil Update File Dokumentasi : " . $nama_dokumentasi . " - " . $uuid_dokumentasi,
                ];
                return response()->json($response, 200);
            } else {
                $response = [
                    "status" => false,
                    "message" => "Berhasil Update File Dokumentasi : " . $nama_dokumentasi . " - " . $uuid_dokumentasi,
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
        $dataPdp->RelFileDokumentasi;

        // data file Dokumentasi
        $dataFileDokumentasi = PdpFileDokumentasi::findOrFail($uuid);

        // response
        $response = [
            "status" => true,
            "data" => $dataFileDokumentasi,
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
        $dataPdp->RelFileDokumentasi;

        // uuid
        $uuid = $request->uuid;

        // data
        $data = PdpFileDokumentasi::findOrFail($uuid);

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
        // if ($data->file_dokumentasi !== null) {
        //     $file_dokumentasi_unlik = $data->file_dokumentasi;
        //     if (Storage::disk('public')->exists($file_dokumentasi_unlik)) {
        //         unlink(storage_path('app/public/' . $file_dokumentasi_unlik));
        //     }
        // }

        // save
        // $save_1 = $data->forceDelete();
        $save_1 = $data->delete();
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("pdp_file_dokumentasi"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Schedule Apps",
                "subjek" => "Berhasil Menghapus File Dokumentasi: " . $data->nama_dokumentasi . " - " . $uuid,
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
