<?php

namespace App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\tinjut\action;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PdpFileDokumentasi;
use App\Models\PdpPenjadwalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ScdTinjutActionDokumentasiController extends Controller
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
        $RelFileDokumentasi = $data->RelFileDokumentasi;

        return view('pages.admin.schedule_apps.tindak_lanjut.action.dokumentasi.index', compact(
            'tags_jp',
            'enc_uuid',
            'jenis_uttp',
            'data',
            'permohonan',
            'profile',
            'RelAlamat',
            'jp',
            'RelFileDokumentasi',
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

        // cek create atau update
        if ($request->uuid_update === null) {
            // create
            // validate
            $request->validate([
                "repeat_dokumentasi" => "required|array",
            ]);
            // repeat form
            $save_1 = 0;
            $repeat_dokumentasi = $request->repeat_dokumentasi;
            $crepeat_dokumentasi = count($repeat_dokumentasi);
            // return dd($request->repeat_dokumentasi[0]['file_dokumentasi']);
            // return dd($request->file('repeat_dokumentasi')[0]['file_dokumentasi']->extension());
            for ($i = 0; $i < $crepeat_dokumentasi; $i++) {
                // value_1
                $uuid_dokumentasi = Str::uuid();
                $nama_dokumentasi = $repeat_dokumentasi[$i]['nama_dokumentasi'];
                $value_1 = [
                    "uuid" => $uuid_dokumentasi,
                    "uuid_penjadwalan" => $uuid,
                    "nama_dokumentasi" => $nama_dokumentasi,
                    "uuid_created" => $auth->uuid_profile,
                ];
                // file_dokumentasi
                $nomor_order = Str::slug($dataPdp->nomor_order);
                $path = "file_dokumentasi/" . date('Y', strtotime($dataPdp->tanggal_peneraan)) . "/" . $nomor_order;
                if (isset($request->repeat_dokumentasi[$i]['file_dokumentasi'])) {
                    $ext = strtolower($request->file('repeat_dokumentasi')[$i]['file_dokumentasi']->extension());
                    $ext_array = array('jpg', 'jpeg', 'png');
                    if (in_array($ext, $ext_array)) {
                        $file = $request->file('repeat_dokumentasi')[$i]['file_dokumentasi'];
                        $filename = $file->getClientOriginalName();
                        $name = ucwords(pathinfo($filename, PATHINFO_FILENAME));
                        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                        $size = $file->getSize();
                        $file_name = Str::slug($nama_dokumentasi, '-');
                        $file_name = $file_name . "-" . rand(1000, 9999999999) . "-[SIMEGAL]." . Str::lower($ext);
                        $file_save = $path . "/" . $file_name;
                        if (!is_dir(storage_path('app/public/' . $path))) {
                            Storage::disk('public')->makeDirectory($path);
                        }
                        Storage::disk('public')->putFileAs($path, $file, $file_name);
                    } else {
                        continue;
                    }
                    $value_1['file_dokumentasi'] = $file_save;
                    $value_1['tipe'] = Str::lower($ext);
                    $value_1['size'] = $size;
                }

                // save
                $create = PdpFileDokumentasi::create($value_1);
                if ($create) {
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
                        "device" => "web",
                        "dashboard" => "1",
                    ];
                    CID::addToLogAktifitas($request, $log);
                    $save_1 += $i;
                }
            }

            if ($save_1 > 0) {
                // alert success
                alert()->success('Berhasil!', 'Berhasil Upload File Dokumentasi.');
                return back();
            } else {
                alert()->error('Gagal!', 'Gagal Upload File Dokumentasi.');
                return back()->withInput($request->all());
            }
        } else {
            // update
            // value_1
            $uuid_dokumentasi = $request->uuid_update;
            // cek file Dokumentasi
            $dataFile = PdpFileDokumentasi::findOrFail($uuid_dokumentasi);
            $nama_dokumentasi = $request->edit_nama_dokumentasi;
            $value_1 = [
                "nama_dokumentasi" => $nama_dokumentasi,
                "uuid_updated" => $auth->uuid_profile,
            ];
            // file_dokumentasi
            $nomor_order = Str::slug($dataPdp->nomor_order);
            $path = "file_dokumentasi/" . date('Y', strtotime($dataPdp->tanggal_peneraan)) . "/" . $nomor_order;
            if ($request->hasFile('edit_file_dokumentasi')) {
                // validate
                $request->validate([
                    "edit_file_dokumentasi" => "required|image|mimes:jpg,jpeg,png|max:5000",
                ]);

                if ($dataFile->file_dokumentasi !== null) {
                    $file_dokumentasi_unlik = $dataFile->file_dokumentasi;
                    if (Storage::disk('public')->exists($file_dokumentasi_unlik)) {
                        unlink(storage_path('app/public/' . $file_dokumentasi_unlik));
                    }
                }

                $ext = strtolower($request->file('edit_file_dokumentasi')->extension());
                $ext_array = array('jpg', 'jpeg', 'png');
                if (in_array($ext, $ext_array)) {
                    $file = $request->file('edit_file_dokumentasi');
                    $filename = $file->getClientOriginalName();
                    $name = ucwords(pathinfo($filename, PATHINFO_FILENAME));
                    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    $size = $file->getSize();
                    $file_name = Str::slug($nama_dokumentasi, '-');
                    $file_name = $file_name . "-" . rand(1000, 9999999999) . "-[SIMEGAL]." . Str::lower($ext);
                    $file_save = $path . "/" . $file_name;
                    if (!is_dir(storage_path('app/public/' . $path))) {
                        Storage::disk('public')->makeDirectory($path);
                    }
                    Storage::disk('public')->putFileAs($path, $file, $file_name);
                } else {
                    alert()->error('Error!', 'Gagal Menyimpan Data, File Dokumentasi Tidak Sesuai Format!');
                    return \back();

                }
                $value_1['file_dokumentasi'] = $file_save;
                $value_1['tipe'] = Str::lower($ext);
                $value_1['size'] = $size;
            }
            // save
            $save_1 = $dataFile->update($value_1);
            if ($save_1) {
                // create log
                $aktifitas = [
                    "tabel" => array("pdp_file_dokumentasi"),
                    "uuid" => array($uuid_dokumentasi),
                    "value" => array($value_1),
                ];
                $log = [
                    "apps" => "Schedule Apps",
                    "subjek" => "Update File Dokumentasi!",
                    "aktifitas" => $aktifitas,
                    "device" => "web",
                    "dashboard" => "1",
                ];
                CID::addToLogAktifitas($request, $log);
                // alert success
                alert()->success('Berhasil!', 'Berhasil Update File Dokumentasi.');
                return back();
            } else {
                alert()->error('Gagal!', 'Gagal Update File Dokumentasi.');
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
