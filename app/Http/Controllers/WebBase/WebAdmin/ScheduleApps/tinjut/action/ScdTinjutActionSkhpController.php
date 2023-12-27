<?php

namespace App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\tinjut\action;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PdpPenjadwalan;
use App\Models\TteSkhp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use QrCode;

class ScdTinjutActionSkhpController extends Controller
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
        $tte = $data->RelTteSkhp;

        return view('pages.admin.schedule_apps.tindak_lanjut.action.skhp.index', compact(
            'tags_jp',
            'enc_uuid',
            'jenis_uttp',
            'data',
            'permohonan',
            'profile',
            'RelAlamat',
            'jp',
            'tte',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $tags_jp, $enc_uuid)
    {
        // proses request
        $path_form = $request->path_form;
        if ($path_form == "generate_qr") {
            return $this->generateQRTte($request, $tags_jp, $enc_uuid);
        } elseif ($path_form == "upload_skhp") {
            return $this->uploadSKHP($request, $tags_jp, $enc_uuid);
        } else {
            return abort(404);
        }
    }
    // store generate QR TTE
    private function generateQRTte($request, $tags_jp, $enc_uuid)
    {
        // auth
        $auth = Auth::user();

        // decode jp
        $jenis_uttp = CID::decode($tags_jp);
        $uuid = CID::decode($enc_uuid);

        // data
        $dataPdp = PdpPenjadwalan::findOrFail($uuid);

        // cek status peneraan
        if ($dataPdp->status_peneraan != "Selesai") {
            alert()->error('Gagal!', 'Status Peneraan Belum Selesai!');
            return back()->withInput($request->all());
        }

        // cek tte
        $cekTte = TteSkhp::where("uuid_penjadwalan", $uuid)->first();
        if ($cekTte !== null) {
            alert()->error('Gagal!', 'QR TTE Sudah di Generate!');
            return back()->withInput($request->all());
        }

        // validate
        $request->validate([
            "jabatan" => "required|string|max:100",
            "nama_pejabat" => "required|string|max:100",
        ]);

        // value_1
        $uuid_tte = Str::uuid();
        $status_apps = "Schedule";
        $kode_tte = CID::genKodeTteSkhp($jenis_uttp, $status_apps);
        $tanggal_generate = date('Y-m-d H:i:s');
        $tanggal_expired = date("Y-m-d", strtotime(date('Y-m-d') . " +1 year"));
        $value_1 = [
            "uuid" => $uuid_tte,
            "uuid_penjadwalan" => $uuid,
            "uuid_pejabat" => $request->nama_pejabat,
            "jabatan_pejabat" => $request->jabatan,
            "kode_tte" => $kode_tte,
            "tanggal_generate" => $tanggal_generate,
            "tanggal_expired" => $tanggal_expired,
            "status_apps" => $status_apps,
            "uuid_created" => $auth->uuid_profile,
        ];
        // save
        $save_1 = TteSkhp::create($value_1);
        if ($save_1) {
            // create file qr
            $url = route('cek.tte.skhp', $kode_tte);
            $path = 'tte_qr/' . date('Y', strtotime($tanggal_generate)) . '/' . $kode_tte;
            $filename = $path . '/QR-TTE-' . $kode_tte . '.png';
            // cek folder
            if (!is_dir(storage_path('/app/public/' . $path))) {
                Storage::disk('public')->makeDirectory($path);
            }
            // cek file
            if (!file_exists(storage_path('/app/public/' . $filename))) {
                QrCode::format('png')->size(200)->generate($url, storage_path('/app/public/' . $filename));
            }
            // create log
            $aktifitas = [
                "tabel" => array("tte_skhp"),
                "uuid" => array($uuid_tte),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Schedule Apps",
                "subjek" => "Generate QR TTE : " . $kode_tte . " - " . $uuid_tte,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "1",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Berhasil!', 'Berhasil Generate QR TTE.');
            return back();
        } else {
            alert()->error('Gagal!', 'Gagal Generate QR TTE.');
            return back()->withInput($request->all());
        }
    }
    // store upload skhp
    private function uploadSKHP($request, $tags_jp, $enc_uuid)
    {
        // auth
        $auth = Auth::user();

        // decode jp
        $jenis_uttp = CID::decode($tags_jp);
        $uuid = CID::decode($enc_uuid);

        // data
        $dataPdp = PdpPenjadwalan::findOrFail($uuid);

        // cek status peneraan
        if ($dataPdp->status_peneraan != "Selesai") {
            alert()->error('Gagal!', 'Status Peneraan Belum Selesai!');
            return back()->withInput($request->all());
        }

        // cek tte
        $data = TteSkhp::where("uuid_penjadwalan", $uuid)->first();
        if ($data === null) {
            alert()->error('Gagal!', 'Data TTE Tidak Ditemukan!');
            return back();
        }

        // validate
        $request->validate([
            "tanggal_expired" => "required|string|max:10",
        ]);

        // value_1
        $tanggal_expired = date('Y-m-d 00:00:00', strtotime($request->tanggal_expired));
        $value_1 = [
            "tanggal_expired" => $tanggal_expired,
            "uuid_updated" => $auth->uuid_profile,
        ];

        // file_skhp
        $uuid_tte = $data->uuid;
        $kode_tte = $data->kode_tte;
        $path = "file_skhp/" . date('Y', strtotime($data->tanggal_generate)) . "/" . $kode_tte;
        if ($request->hasFile('file_skhp')) {
            // validate
            $request->validate([
                "file_skhp" => "required|file|mimes:pdf|max:50000",
            ]);

            if ($data->file_skhp !== null) {
                $file_skhp_unlik = $data->file_skhp;
                if (Storage::disk('public')->exists($file_skhp_unlik)) {
                    unlink(storage_path('app/public/' . $file_skhp_unlik));
                }
            }

            $file_skhp = CID::UpFileSKHP($request, "file_skhp", $path);
            if ($file_skhp == "0") {
                alert()->error('Error!', 'Gagal Menyimpan Data, File SKHP Tidak Sesuai Format!');
                return \back();
            }
            $value_1['file_skhp'] = $file_skhp['url'];
            $value_1['tipe'] = $file_skhp['tipe_file'];
            $value_1['size'] = $file_skhp['ukuran_file'];
        }

        // save
        $save_1 = $data->update($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("tte_skhp"),
                "uuid" => array($uuid_tte),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Schedule Apps",
                "subjek" => "Upload File SKHP : " . $kode_tte . " - " . $uuid_tte,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "1",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Berhasil!', 'Berhasil Upload File SKHP.');
            return back();
        } else {
            alert()->error('Gagal!', 'Gagal Upload File SKHP.');
            return back()->withInput($request->all());
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
        $data = TteSkhp::findOrFail($uuid);

        // cek ACC
        if ($data->status_acc !== "0") {
            // success
            $msg = "Data Gagal Dihapus, TTE Sudah Di Proses Oleh Pejabat Penandatangan!";
            $response = [
                "status" => false,
                "message" => $msg,
            ];
            return response()->json($response, 422);
        }

        // cek file skhp
        if ($data->file_skhp !== null) {
            // success
            $msg = "Data Gagal Dihapus, Dokumen SKHP Sudah Di Unggah!";
            $response = [
                "status" => false,
                "message" => $msg,
            ];
            return response()->json($response, 422);
        }

        // delete folder
        $kode_tte = $data->kode_tte;
        $path_tte = 'tte_qr/' . date('Y', strtotime($data->tanggal_generate)) . '/' . $kode_tte;
        if (Storage::disk('public')->exists($path_tte)) {
            Storage::disk('public')->deleteDirectory($path_tte);
        }

        // save
        $save_1 = $data->forceDelete();
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("tte_skhp"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Schedule Apps",
                "subjek" => "Berhasil Menghapus TTE SKHP: " . $data->kode_tte . " - " . $uuid,
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

    // downloadTte
    public function downloadTte($tags_jp, $enc_uuid, $kode_tte)
    {
        // decode jp
        $jenis_uttp = CID::decode($tags_jp);
        $uuid = CID::decode($enc_uuid);
        // data
        $pdp = PdpPenjadwalan::findOrFail($uuid);
        $permohonan = $pdp->RelPermohonanPeneraan;
        $profile = $permohonan->RelPerusahaan;
        $data = TteSkhp::whereKodeTte($kode_tte)->firstOrFail();
        $url = route('cek.tte.skhp', $data->kode_tte);
        $path = 'tte_qr/' . date('Y', strtotime($data->tanggal_generate)) . '/' . $kode_tte;
        $filename = $path . '/QR-TTE-' . $kode_tte . '.png';
        // cek folder
        if (!is_dir(storage_path('/app/public/' . $path))) {
            Storage::disk('public')->makeDirectory($path);
        }
        // cek file
        if (!file_exists(storage_path('/app/public/' . $filename))) {
            QrCode::format('png')->size(200)->generate($url, storage_path('/app/public/' . $filename));
        }
        return response()->download(storage_path('/app/public/' . $filename));
    }
}
