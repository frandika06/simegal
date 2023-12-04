<?php

namespace App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\tinjut\action;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\MasterFitur;
use App\Models\PdpPenjadwalan;
use App\Models\PdpRetribusi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use QrCode;

class ScdTinjutActionRetribusiController extends Controller
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
        $skrd = $data->RelPdpRetribusi;
        $uuid_permohonan = $data->uuid_permohonan;
        $permohonan = $data->RelPermohonanPeneraan;
        $profile = $permohonan->RelPerusahaan;
        $RelAlamat = $permohonan->RelAlamatPerusahaan;
        $jp = $permohonan->jenis_pengujian;

        // cek fitur retribusi
        $fitur = MasterFitur::where("nama_fitur", "Retribusi")->first();
        if ($fitur->status == "0") {
            alert()->warning('Fitur Non-Aktif!', 'Fitur Retribusi Di Non-Aktifkan!');
            return redirect()->route('scd.apps.tinjut.' . $jenis_uttp . '.index');
        }

        return view('pages.admin.schedule_apps.tindak_lanjut.action.retribusi.index', compact(
            'tags_jp',
            'enc_uuid',
            'jenis_uttp',
            'data',
            'skrd',
            'permohonan',
            'profile',
            'RelAlamat',
        ));
    }

    /**
     * generateSkrd - generate skrd
     */
    public function generateSkrd(Request $request, $tags_jp, $enc_uuid)
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
            // gagal
            $msg = "Status Peneraan Belum Selesai!";
            $response = [
                "status" => false,
                "message" => $msg,
            ];
            return response()->json($response, 422);
        }

        // cek retribusi
        $pdpRetribusi = PdpRetribusi::where("uuid_penjadwalan", $uuid)->first();
        if ($pdpRetribusi === null) {
            // gagal
            $msg = "Data Retribusi Tidak Ditemukan!";
            $response = [
                "status" => false,
                "message" => $msg,
            ];
            return response()->json($response, 422);
        }

        // cek generate
        if ($pdpRetribusi->kode_bayar_webr !== null) {
            // gagal
            $msg = "SKRD Sudah Di Proses!";
            $response = [
                "status" => false,
                "message" => $msg,
            ];
            return response()->json($response, 422);
        }

        // base
        $uuid_retribusi = $pdpRetribusi->uuid;

        // proses webr
        $carbon_date = Carbon::now();
        $skrd_generated_at = $carbon_date->format('Y-m-d H:i:s');
        $tgl_skrd = $carbon_date->format('Y-m-d');
        $tgl_jatuh_tempo = $carbon_date->addDays(14)->format('Y-m-d');

        $permohonan = $dataPdp->RelPermohonanPeneraan;
        $perusahaan = $permohonan->RelPerusahaan;
        $id_perusahaan = $perusahaan->kode_perusahaan;
        $nama_perusahaan = $perusahaan->nama_perusahaan;
        $alamat_perusahaan = CID::getAlamatPerusahaan($permohonan);

        $no_skrd = $dataPdp->nomor_order;
        $biaya = $pdpRetribusi->total_retribusi;

        $response = CID::webrSetInvoice($id_perusahaan, $nama_perusahaan,
            $alamat_perusahaan, $biaya, $no_skrd, $tgl_skrd, $tgl_jatuh_tempo);

        $resp = json_decode($response);

        if (isset($resp->error)) {
            // gagal
            $msg = 'WEB-R Error: ' . $resp->error->message;
            $response = [
                "status" => false,
                "message" => $msg,
            ];
            return response()->json($response, 422);
        }

        $kode_bayar_webr = $resp->result->data->kd_bayar;

        // value_1
        $value_1 = [
            "tgl_skrd" => $skrd_generated_at,
            "tgl_jatuh_tempo" => $tgl_jatuh_tempo,
            "kode_bayar_webr" => $kode_bayar_webr,
            "uuid_generate_skrd" => $auth->uuid_profile,
        ];

        // save
        $save_1 = $pdpRetribusi->update($value_1);
        if ($save_1) {
            // create file qr
            $path = 'skrd/' . date('Y', strtotime($skrd_generated_at)) . '/' . $kode_bayar_webr;
            $filename = $path . '/KODE-BAYAR-SKRD-' . $kode_bayar_webr . '.png';
            // cek folder
            if (!is_dir(storage_path('/app/public/' . $path))) {
                Storage::disk('public')->makeDirectory($path);
            }
            // cek file
            if (!file_exists(storage_path('/app/public/' . $filename))) {
                QrCode::format('png')->size(200)->generate($kode_bayar_webr, storage_path('/app/public/' . $filename));
            }
            // create log
            $aktifitas = [
                "tabel" => array("pdp_retribusi"),
                "uuid" => array($uuid_retribusi),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Schedule Apps",
                "subjek" => "Generate SKRD : " . $kode_bayar_webr . " - " . $uuid_retribusi,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "1",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            $msg = 'Berhasil Generate SKRD.';
            $response = [
                "status" => true,
                "message" => $msg,
            ];
            return response()->json($response, 200);
        } else {
            // gagal
            $msg = 'Gagal Generate SKRD.';
            $response = [
                "status" => false,
                "message" => $msg,
            ];
            return response()->json($response, 422);
        }
    }

    // downloadKodeBayar
    public function downloadKodeBayar($tags_jp, $enc_uuid, $kode_bayar_webr)
    {
        // decode jp
        $jenis_uttp = CID::decode($tags_jp);
        $uuid = CID::decode($enc_uuid);
        // data
        $pdp = PdpPenjadwalan::findOrFail($uuid);
        $data = PdpRetribusi::whereKodeBayarWebr($kode_bayar_webr)->firstOrFail();
        $path = 'skrd/' . date('Y', strtotime($data->tgl_skrd)) . '/' . $kode_bayar_webr;
        $filename = $path . '/KODE-BAYAR-SKRD-' . $kode_bayar_webr . '.png';
        // cek folder
        if (!is_dir(storage_path('/app/public/' . $path))) {
            Storage::disk('public')->makeDirectory($path);
        }
        // cek file
        if (!file_exists(storage_path('/app/public/' . $filename))) {
            QrCode::format('png')->size(200)->generate($kode_bayar_webr, storage_path('/app/public/' . $filename));
        }
        return response()->download(storage_path('/app/public/' . $filename));
    }
}
