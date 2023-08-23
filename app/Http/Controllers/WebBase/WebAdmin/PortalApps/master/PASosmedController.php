<?php

namespace App\Http\Controllers\WebBase\WebAdmin\PortalApps\master;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PortalSosmed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PASosmedController extends Controller
{
    // index
    public function index()
    {
        // auth
        $auth = Auth::user();

        // cek data sosmed
        $cekSosmed = PortalSosmed::first();
        if ($cekSosmed === null) {
            // create
            $sosmed = [
                "Facebook",
                "Twitter",
                "Instagram",
                "YouTube",
            ];
            $url = [
                "https://www.facebook.com/",
                "https://www.twitter.com/",
                "https://www.instagram.com/",
                "https://www.youtube.com/",
            ];
            $csosmed = count($sosmed);
            for ($i = 0; $i < $csosmed; $i++) {
                // value
                $value_1 = [
                    "uuid" => Str::uuid(),
                    "sosmed" => $sosmed[$i],
                    "url" => $url[$i],
                    "uuid_created" => $auth->uuid_profile,
                ];
                // save
                PortalSosmed::create($value_1);
            }
        }

        // update
        $data = PortalSosmed::all();
        return view('pages.admin.portal_apps.sosmed.create_edit', compact(
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
            CID::addToLogAktifitas($request, $log);
        }

        // save
        if ($save_1) {
            // alert success
            alert()->success('Success', "Berhasil Mengubah Data!");
            return \redirect()->route('prt.apps.mst.sosmed.index');
        } else {
            alert()->error('Error', "Gagal Mengubah Data!");
            return \back()->withInput($request->all());
        }

    }
}
