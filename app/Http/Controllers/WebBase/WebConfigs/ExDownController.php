<?php

namespace App\Http\Controllers\WebBase\WebConfigs;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PortalUnduhan;
use Storage;

class ExDownController extends Controller
{
    // unduhan - media unduhan portal
    public function unduhan($uuid_enc)
    {
        $uuid = CID::decode($uuid_enc);
        $data = PortalUnduhan::findOrFail($uuid);

        // update downloads
        $downloads = $data->downloads + 1;
        $data->update(["downloads" => $downloads]);
        $url = $data->url;
        $file_name = substr(strrchr(rtrim($url, '/'), '/'), 1);
        if (Storage::disk('public')->exists($url)) {
            $headers = array('Content-Type: application/octet-stream');
            return Storage::disk('public')->download($url, $file_name, $headers);
        }
    }
}
