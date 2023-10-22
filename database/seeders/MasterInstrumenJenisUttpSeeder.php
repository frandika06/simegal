<?php

namespace Database\Seeders;

use App\Models\MasterInstrumenJenisUttp;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MasterInstrumenJenisUttpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // user
        $user = User::where("role", "Super Admin")->first();

        // cek master instrumen jenis uttp
        $cekInsJenisUttp = MasterInstrumenJenisUttp::first();
        if ($cekInsJenisUttp === null) {
            $ar_value = [
                "TAKARAN (BASAH/KERING)",
                "TANGKI UKUR TETAP SILINDER DATAR",
                "TANGKI UKUR MOBIL",
                "BEJANA UKUR",
                "POMPA UKUR",
                "METER AIR",
                "METER LISTRIK (KWH)",
                "TIMBANGAN",
                "PENGUJIAN KWANTA BDKT",
            ];

            // value
            $car_value = count($ar_value);
            for ($i = 0; $i < $car_value; $i++) {
                // status_volume
                if ($ar_value[$i] == "METER LISTRIK (KWH)" || $ar_value[$i] == "PENGUJIAN KWANTA BDKT") {
                    $status_volume = "0";
                } else {
                    $status_volume = "1";
                }

                // value_1
                $uuid = Str::uuid();
                $value_1 = [
                    "uuid" => $uuid,
                    "no_urut" => $i + 1,
                    "nama_jenis_uttp" => $ar_value[$i],
                    "status_volume" => $status_volume,
                    "uuid_created" => $user->uuid_profile,
                ];
                MasterInstrumenJenisUttp::create($value_1);
            }
        }
    }
}
