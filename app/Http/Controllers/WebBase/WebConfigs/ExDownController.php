<?php

namespace App\Http\Controllers\WebBase\WebConfigs;

use App\Exports\SettingsApps\ExFormatMasterItemUttp;
use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Imports\SettingsApp\ImMasterItemUttp;
use App\Models\PortalUnduhan;
use App\Models\TteSkhp;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Storage;

class ExDownController extends Controller
{
    /*
    |
    | DOWNLOAD
    |
     */
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
        } else {
            return \abort(404);
        }
    }
    // unduhSkhp
    public function unduhSkhp($kode_tte)
    {
        $data = TteSkhp::whereKodeTte($kode_tte)->firstOrFail();

        // update downloads
        $downloads = $data->downloads + 1;
        $data->update(["downloads" => $downloads]);
        $url = $data->file_skhp;
        // $file_name = substr(strrchr(rtrim($url, '/'), '/'), 1);
        $file_name = $kode_tte . "-" . date('Ymd') . ".pdf";
        if (Storage::disk('public')->exists($url)) {
            $headers = array('Content-Type: application/octet-stream');
            return Storage::disk('public')->download($url, $file_name, $headers);
        } else {
            return \abort(404);
        }
    }

    /*
    |
    | EXPORT - EXCEL
    |
     */
    // SetExFormatMasterItemUttp
    public function SetExFormatMasterItemUttp()
    {
        $date = date('dmy-His');
        $filename = "[EXPORT]-[FORMAT IMPORT DAFTAR ITEM UTTP]-" . $date;
        return Excel::download(new ExFormatMasterItemUttp(), $filename . '.xlsx');
    }

    /*
    |
    | IMPORT - EXCEL
    |
     */
    // SetImFormatMasterItemUttp
    public function SetImFormatMasterItemUttp(Request $request)
    {
        // validate
        $request->validate([
            "file_import" => "required|file|mimes:xls,xlsx|max:1000000",
        ]);

        if ($request->hasFile('file_import')) {
            Excel::import(new ImMasterItemUttp(), request()->file('file_import'));
            $success = $request->session()->get('im-success');
            $failed = $request->session()->get('im-failed');
            alert()->info('Notifikasi Import', 'Sukses: ' . $success . ' | Gagal:' . $failed);
            return back();
        }
    }
}
