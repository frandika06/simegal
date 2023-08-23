<?php

namespace App\Http\Controllers\WebBase\WebAdmin\PortalApps\master;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PortalSetup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PASetupController extends Controller
{
    // index
    public function index()
    {
        // auth
        $auth = Auth::user();
        // cek data setup
        $cekSetup = PortalSetup::first();
        if ($cekSetup === null) {
            // create
            $value_1 = [
                "uuid" => Str::uuid(),
                "google_maps" => "https: //goo.gl/maps/HT6TtdJCVubJqRB69",
                "alamat" => "Bidang Metrologi Legal, Balaraja, Kec. Balaraja, Kabupaten Tangerang, Banten 15610.",
                "no_telp" => "(021) 123-4567",
                "email" => "info@simegal.tangerangkab.go.id",
                "link_survey" => "https://s.id/survey-simegal-23",
                "uuid_created" => $auth->uuid_profile,
            ];
            PortalSetup::create($value_1);
        }
        // data
        $data = PortalSetup::first();
        return view('pages.admin.portal_apps.setup.create_edit', compact(
            'data'
        ));
    }

    // update
    public function update(Request $request)
    {
        // auth
        $auth = Auth::user();

        // validate
        $request->validate([
            "google_maps" => "required|string|max:300",
            "alamat" => "required|string|max:300",
            "no_telp" => "required|string|max:100",
            "email" => "required|string|max:100",
            "link_survey" => "required|string|max:100",
        ]);

        // data
        $data = PortalSetup::first();
        $uuid = $data->uuid;

        // value
        $value_1 = [
            "google_maps" => $request->google_maps,
            "alamat" => $request->alamat,
            "no_telp" => $request->no_telp,
            "email" => Str::lower($request->email),
            "link_survey" => $request->link_survey,
            "uuid_updated" => $auth->uuid_profile,
        ];
        // save
        $save_1 = $data->update($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("portal_setup"),
                "uuid" => array($uuid),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "SIMEGAL",
                "subjek" => "Portal Apps | Mengubah Data Master Setup Portal UUID= " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Success', "Berhasil Mengubah Data!");
            return \redirect()->route('prt.apps.mst.setup.index');
        } else {
            alert()->error('Error', "Gagal Mengubah Data!");
            return \back()->withInput($request->all());
        }
    }
}
