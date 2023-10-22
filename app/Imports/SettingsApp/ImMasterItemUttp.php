<?php

namespace App\Imports\SettingsApp;

use App\Models\MasterInstrumenDaftarItemUttp;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImMasterItemUttp implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        // auth
        $auth = Auth::user();

        $i = 0;
        $success = 0;
        $failed = 0;
        Session::put('im-success', $success);
        Session::put('im-failed', $failed);
        foreach ($rows as $item) {
            // Ambil Dari Data Pertama
            if ($i > 0) {
                if ($item[1] !== null) {
                    $uuid_instrumen_jenis_uttp = $item[1];
                    $no_urut = $item[3];
                    $value_1 = [
                        "uuid" => Str::uuid(),
                        "uuid_instrumen_jenis_uttp" => $uuid_instrumen_jenis_uttp,
                        "no_urut" => (int) $no_urut,
                        "nama_instrumen" => $item[4],
                        "volume_from" => (int) $item[5],
                        "volume_to" => (int) $item[6],
                        "volume_per" => (int) $item[7],
                        "satuan" => $item[8],
                        "tera_baru_pengujian" => (int) $item[9],
                        "tera_baru_pejustiran" => (int) $item[10],
                        "tera_ulang_pengujian" => (int) $item[11],
                        "tera_ulang_pejustiran" => (int) $item[12],
                        "tarif_per_jam" => (int) $item[13],
                        "uuid_created" => $auth->uuid_profile,
                    ];
                    $save_1 = MasterInstrumenDaftarItemUttp::create($value_1);
                    if ($save_1) {
                        $success = $success + 1;
                        Session::put('im-success', $success);
                    } else {
                        $failed = $failed + 1;
                        Session::put('im-failed', $failed);
                    }
                }
            }
            $i++;
        }
    }
}
