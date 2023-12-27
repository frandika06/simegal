<?php

namespace App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\tinjut\action;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PdpFileBa;
use App\Models\PdpPenjadwalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ScdTinjutActionBaController extends Controller
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
        $RelFileBa = $data->RelFileBa;

        return view('pages.admin.schedule_apps.tindak_lanjut.action.ba.index', compact(
            'tags_jp',
            'enc_uuid',
            'jenis_uttp',
            'data',
            'permohonan',
            'profile',
            'RelAlamat',
            'jp',
            'RelFileBa',
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
            "jenis_ba" => "required|string|max:300",
            "keterangan" => "sometimes|nullable|string|max:1000",
        ]);

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
                $request->validate([
                    "file_ba" => "required|file|mimes:pdf|max:50000",
                ]);

                $file_ba = CID::UpFilePdf($request, "file_ba", $path);
                if ($file_ba == "0") {
                    alert()->error('Error!', 'Gagal Menyimpan Data, File BA Tidak Sesuai Format!');
                    return \back();
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
                    "device" => "web",
                    "dashboard" => "1",
                ];
                CID::addToLogAktifitas($request, $log);
                // alert success
                alert()->success('Berhasil!', 'Berhasil Upload File BA.');
                return back();
            } else {
                alert()->error('Gagal!', 'Gagal Upload File BA.');
                return back()->withInput($request->all());
            }
        } else {
            // update
            // value_1
            $uuid_ba = $request->uuid_update;
            // cek file BA
            $dataCerapan = PdpFileBa::findOrFail($uuid_ba);
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
                $request->validate([
                    "file_ba" => "required|file|mimes:pdf|max:50000",
                ]);

                if ($dataCerapan->file_ba !== null) {
                    $file_ba_unlik = $dataCerapan->file_ba;
                    if (Storage::disk('public')->exists($file_ba_unlik)) {
                        unlink(storage_path('app/public/' . $file_ba_unlik));
                    }
                }

                $file_ba = CID::UpFilePdf($request, "file_ba", $path);
                if ($file_ba == "0") {
                    alert()->error('Error!', 'Gagal Menyimpan Data, File BA Tidak Sesuai Format!');
                    return \back();
                }
                $value_1['file_ba'] = $file_ba['url'];
                $value_1['tipe'] = $file_ba['tipe_file'];
                $value_1['size'] = $file_ba['ukuran_file'];
            }
            // save
            $save_1 = $dataCerapan->update($value_1);
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
                    "device" => "web",
                    "dashboard" => "1",
                ];
                CID::addToLogAktifitas($request, $log);
                // alert success
                alert()->success('Berhasil!', 'Berhasil Update File BA.');
                return back();
            } else {
                alert()->error('Gagal!', 'Gagal Update File BA.');
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
