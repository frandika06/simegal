<?php

namespace App\Http\Controllers\WebBase\WebAdmin\auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PAProfileController extends Controller
{
    // index
    public function index()
    {
        // auth
        $data = Auth::user();
        return view('pages.admin.portal_apps.auth.profile', compact(
            'data'
        ));
    }

    // update
    public function update(Request $request)
    {
        // auth
        $auth = Auth::user();

        // uuid
        $uuids = $request->uuid;
        $sosmed = $request->sosmed;
        $url = $request->url;
        $cuuid = count($uuids);
        for ($i = 0; $i < $cuuid; $i++) {
            // value
            $uuid = $uuids[$i];
            // cek data
            $data = PortalSosmed::whereUuid($uuid)->first();
            if ($data === null) {
                continue;
            }
            $value_1 = [
                "sosmed" => $sosmed[$i],
                "url" => $url[$i],
                "uuid_updated" => $auth->uuid_profile,
            ];
            $save_1 = $data->update($value_1);
            // create log
            $aktifitas = [
                "tabel" => array("portal_sosmed"),
                "uuid" => array($uuid),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "SIMEGAL",
                "subjek" => "Portal Apps | Mengubah Data Master Sosial Media UUID= " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
            ];
        }

        // save
        if ($save_1) {
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Success', "Berhasil Mengubah Data!");
            return \redirect()->route('prt.apps.mst.sosmed.index');
        } else {
            alert()->error('Error', "Gagal Mengubah Data!");
            return \back()->withInput($request->all());
        }

    }
}
