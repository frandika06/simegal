<?php

namespace App\Http\Controllers\ApiBase\ApiAdmin\PdpApps\permohonan;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PermohonanPeneraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiPDPPermohonanPeneraanController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // auth
        $auth = auth()->user();
        $profile = $auth->RelPerusahaan;
        $uuid_profile = $auth->uuid_profile;
        $uuid_perusahaan = $profile->uuid;

        // validate
        $validator = Validator::make($request->all(), [
            "jenis_pengujian" => "required|string|max:100",
            "nomor_surat_permohonan" => "required|string|max:100",
            "file_surat_permohonan" => "required|file|mimes:png,jpg,jpeg,pdf|max:5000",
            "tanggal_permohonan" => "required|string|max:10",
            "lokasi_peneraan" => "required|string|max:100",
            "uuid_alamat" => "sometimes|nullable|string|max:100",
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
        $jp = $request->jenis_pengujian;
        $lokasi_peneraan = $request->lokasi_peneraan;
        $kode_permohonan = CID::genKodePermohonan($jp);
        if ($lokasi_peneraan == "Luar Kantor") {
            $uuid_alamat = $request->uuid_alamat;
        } else {
            $uuid_alamat = null;
        }
        $uuid = Str::uuid();
        $value_1 = [
            "uuid" => $uuid,
            "uuid_perusahaan" => $uuid_perusahaan,
            "kode_permohonan" => $kode_permohonan,
            "jenis_pengujian" => $jp,
            "nomor_surat_permohonan" => $request->nomor_surat_permohonan,
            "tanggal_permohonan" => date('Y-m-d', strtotime($request->tanggal_permohonan)),
            "lokasi_peneraan" => $lokasi_peneraan,
            "uuid_alamat" => $uuid_alamat,
            "status" => "Baru",
            "uuid_created" => $uuid_profile,
        ];

        // file_surat_permohonan
        $path = "permohonan/" . date('Y') . "/" . $kode_permohonan;
        if ($request->hasFile('file_surat_permohonan')) {
            $file_surat_permohonan = CID::UpImgPdf($request, "file_surat_permohonan", $path);
            if ($file_surat_permohonan == "0") {
                $response = [
                    "status" => false,
                    "message" => "Gagal Menyimpan Data, File Surat Permohonan Tidak Sesuai Format!",
                    "request" => $request->all(),
                ];
                return response()->json($response, 422);
            }
            $value_1['file_surat_permohonan'] = $file_surat_permohonan['url'];
        }

        // save
        $save_1 = PermohonanPeneraan::create($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("permohonan_peneraan"),
                "uuid" => array($uuid),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Penjadwalan dan Penugasan Apps",
                "subjek" => "Berhasil Mengajukan Permohonan Pengujian (" . $kode_permohonan . ") dengan UUID= " . $uuid,
                "aktifitas" => $aktifitas,
                "role" => "Perusahaan",
                "device" => "mobile",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            $response = [
                "status" => true,
                "message" => "Berhasil Mengajukan Permohonan Pengujian.",
            ];
            return response()->json($response, 201);
        } else {
            $response = [
                "status" => false,
                "message" => "Gagal Mengajukan Permohonan Pengujian.",
                "request" => $request->all(),
            ];
            return response()->json($response, 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($uuid_enc)
    {
        // auth
        $auth = auth()->user();
        $profile = $auth->RelPerusahaan;

        // uuid
        $uuid = $uuid_enc;
        $data = PermohonanPeneraan::with('RelPerusahaan')
            ->with('RelAlamatPerusahaan')
            ->with('RelVerifikator')
            ->findOrFail($uuid);

        // response
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid_enc)
    {
        // auth
        $auth = auth()->user();
        $profile = $auth->RelPerusahaan;
        $uuid_profile = $auth->uuid_profile;
        $uuid_perusahaan = $profile->uuid;

        // validate
        $validator = Validator::make($request->all(), [
            "nomor_surat_permohonan" => "required|string|max:100",
            "file_surat_permohonan" => "sometimes|nullable|file|mimes:png,jpg,jpeg,pdf|max:5000",
            "tanggal_permohonan" => "required|string|max:10",
            "lokasi_peneraan" => "required|string|max:100",
            "uuid_alamat" => "sometimes|nullable|string|max:100",
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

        // uuid
        $uuid = $uuid_enc;
        $data = PermohonanPeneraan::findOrFail($uuid);

        // value
        $lokasi_peneraan = $request->lokasi_peneraan;
        $kode_permohonan = $data->kode_permohonan;
        if ($lokasi_peneraan == "Luar Kantor") {
            $uuid_alamat = $request->uuid_alamat;
        } else {
            $uuid_alamat = null;
        }
        $value_1 = [
            "nomor_surat_permohonan" => $request->nomor_surat_permohonan,
            "tanggal_permohonan" => date('Y-m-d', strtotime($request->tanggal_permohonan)),
            "lokasi_peneraan" => $lokasi_peneraan,
            "uuid_alamat" => $uuid_alamat,
            "uuid_updated" => $uuid_profile,
        ];

        // file_surat_permohonan
        $path = "permohonan/" . date('Y', strtotime($data->tanggal_permohonan)) . "/" . $kode_permohonan;
        if ($request->hasFile('file_surat_permohonan')) {
            $file_surat_permohonan = CID::UpImgPdf($request, "file_surat_permohonan", $path);
            if ($file_surat_permohonan == "0") {
                $response = [
                    "status" => false,
                    "message" => "Gagal Menyimpan Data, File Surat Permohonan Tidak Sesuai Format!",
                    "request" => $request->all(),
                ];
                return response()->json($response, 422);
            }
            $value_1['file_surat_permohonan'] = $file_surat_permohonan['url'];
        }

        // save
        $save_1 = $data->update($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("permohonan_peneraan"),
                "uuid" => array($uuid),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Penjadwalan dan Penugasan Apps",
                "subjek" => "Berhasil Mengubah Permohonan Pengujian (" . $kode_permohonan . ") dengan UUID= " . $uuid,
                "aktifitas" => $aktifitas,
                "role" => "Perusahaan",
                "device" => "mobile",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            $response = [
                "status" => true,
                "message" => "Berhasil Mengubah Permohonan Pengujian.",
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                "status" => false,
                "message" => "Gagal Mengubah Permohonan Pengujian.",
                "request" => $request->all(),
            ];
            return response()->json($response, 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // uuid
        $uuid = $request->uuid;

        // data
        $data = PermohonanPeneraan::findOrFail($uuid);

        // save
        $save_1 = $data->delete();
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("permohonan_peneraan"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Penjadwalan dan Penugasan Apps",
                "subjek" => "Berhasil Menghapus Permohonan Peneraan (" . $data->kode_permohonan . ") dengan UUID= " . $uuid,
                "aktifitas" => $aktifitas,
                "role" => "Perusahaan",
                "device" => "mobile",
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
