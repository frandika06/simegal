<?php

namespace Database\Seeders;

use App\Models\MasterJenisPelayanan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MasterUTTPJenisPelayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // user
        $user = User::where("role", "Super Admin")->first();

        // cek master jp
        $cekMasterJP = MasterJenisPelayanan::first();
        if ($cekMasterJP === null) {
            $ar_value = [
                "Tera",
                "Tera Ulang",
                "Pengujian BDKT",
            ];
            $car_value = count($ar_value);
            for ($i = 0; $i < $car_value; $i++) {
                $uuid = Str::uuid();
                $value_1 = [
                    "uuid" => $uuid,
                    "no_urut" => $i + 1,
                    "nama_pelayanan" => $ar_value[$i],
                    "uuid_created" => $user->uuid_profile,
                ];
                MasterJenisPelayanan::create($value_1);
            }
        }
    }
}
