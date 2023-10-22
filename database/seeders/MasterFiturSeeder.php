<?php

namespace Database\Seeders;

use App\Models\MasterFitur;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MasterFiturSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // user
        $user = User::where("role", "Super Admin")->first();

        $ar_value = [
            "Pengujian BDKT",
            "Retribusi",
        ];
        $car_value = count($ar_value);
        for ($i = 0; $i < $car_value; $i++) {
            // cek master fitur
            $nama_fitur = $ar_value[$i];
            $cekMasterFitur = MasterFitur::where("nama_fitur", $nama_fitur)->first();
            if ($cekMasterFitur === null) {
                $uuid = Str::uuid();
                $value_1 = [
                    "uuid" => $uuid,
                    "nama_fitur" => $nama_fitur,
                    "uuid_created" => $user->uuid_profile,
                ];
                MasterFitur::create($value_1);
            }
        }
    }
}
