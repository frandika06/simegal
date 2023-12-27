<?php

namespace App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\tinjut\action;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PdpFileCerapan;
use App\Models\PdpPenjadwalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ScdTinjutActionCerapanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $tags_jp, $enc_uuid)
    {
        // decode jp
        $jenis_uttp = CID::decode($tags_jp);
        $uuid = CID::decode($enc_uuid);

        // data
        $data = PdpPenjadwalan::findOrFail($uuid);
        $permohonan = $data->RelPermohonanPeneraan;
        $profile = $permohonan->RelPerusahaan;
        $RelAlamat = $permohonan->RelAlamatPerusahaan;
        $jp = $permohonan->jenis_pengujian;
        $RelFileCerapan = $data->RelFileCerapan;

        return view('pages.admin.schedule_apps.tindak_lanjut.action.cerapan.index', compact(
            'tags_jp',
            'enc_uuid',
            'jenis_uttp',
            'data',
            'permohonan',
            'profile',
            'RelAlamat',
            'jp',
            'RelFileCerapan',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $tags_jp, $enc_uuid)
    {
        // auth
        $auth = Auth::user();

        // decode jp
        $jenis_uttp = CID::decode($tags_jp);
        $uuid = CID::decode($enc_uuid);

        // data
        $dataPdp = PdpPenjadwalan::findOrFail($uuid);

        // cek status permohonan
        if ($dataPdp->RelPermohonanPeneraan->status == "Selesai") {
            alert()->error('Gagal!', 'Status Permohonan Sudah Selesai!');
            return back()->withInput($request->all());
        }

        // validate
        $request->validate([
            "jenis_cerapan" => "required|string|max:300",
            "keterangan" => "sometimes|nullable|string|max:1000",
        ]);

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
                $request->validate([
                    "file_cerapan" => "required|file|mimes:pdf|max:50000",
                ]);

                $file_cerapan = CID::UpFilePdf($request, "file_cerapan", $path);
                if ($file_cerapan == "0") {
                    alert()->error('Error!', 'Gagal Menyimpan Data, File Cerapan Tidak Sesuai Format!');
                    return \back();
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
                    "device" => "web",
                    "dashboard" => "1",
                ];
                CID::addToLogAktifitas($request, $log);
                // alert success
                alert()->success('Berhasil!', 'Berhasil Upload File Cerapan.');
                return back();
            } else {
                alert()->error('Gagal!', 'Gagal Upload File Cerapan.');
                return back()->withInput($request->all());
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
                $request->validate([
                    "file_cerapan" => "required|file|mimes:pdf|max:50000",
                ]);

                if ($dataCerapan->file_cerapan !== null) {
                    $file_cerapan_unlik = $dataCerapan->file_cerapan;
                    if (Storage::disk('public')->exists($file_cerapan_unlik)) {
                        unlink(storage_path('app/public/' . $file_cerapan_unlik));
                    }
                }

                $file_cerapan = CID::UpFilePdf($request, "file_cerapan", $path);
                if ($file_cerapan == "0") {
                    alert()->error('Error!', 'Gagal Menyimpan Data, File Cerapan Tidak Sesuai Format!');
                    return \back();
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
                    "device" => "web",
                    "dashboard" => "1",
                ];
                CID::addToLogAktifitas($request, $log);
                // alert success
                alert()->success('Berhasil!', 'Berhasil Update File Cerapan.');
                return back();
            } else {
                alert()->error('Gagal!', 'Gagal Update File Cerapan.');
                return back()->withInput($request->all());
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $tags_jp, $enc_uuid)
    {
        // auth
        $auth = Auth::user();

        // uuid
        $uuid = CID::decode($request->uuid);

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
                "device" => "web",
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
