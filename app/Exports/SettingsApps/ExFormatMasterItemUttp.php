<?php

namespace App\Exports\SettingsApps;

use App\Models\MasterInstrumenJenisUttp;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExFormatMasterItemUttp implements FromView
{
    public function view(): View
    {
        $data = MasterInstrumenJenisUttp::orderBy("no_urut", "ASC")->get();
        return view('pages.exports.ex_settings_apps_format_master_item_uttp', compact(
            'data',
        ));
    }
}
