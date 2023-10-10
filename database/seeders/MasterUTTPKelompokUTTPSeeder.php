<?php

namespace Database\Seeders;

use App\Models\MasterJenisPelayanan;
use App\Models\MasterKelompokUttp;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MasterUTTPKelompokUTTPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // user
        $user = User::where("role", "Super Admin")->first();

        // cek master Kuttp
        $cekMasterKuttp = MasterKelompokUttp::first();
        if ($cekMasterKuttp === null) {
            // get JP
            $jp = MasterJenisPelayanan::get();
            foreach ($jp as $item1) {
                $nama_pelayanan = $item1->nama_pelayanan;
                if ($nama_pelayanan == "Tera" || $nama_pelayanan == "Tera Ulang") {
                    $ar_kode = [
                        "MT",
                        "UAPV",
                    ];
                    $ar_value = [
                        "Massa/Timbangan (MT)",
                        "Ukur Arus Panjang & Valume (UAPV)",
                    ];
                    $car_value = count($ar_value);
                    for ($i = 0; $i < $car_value; $i++) {
                        $uuid = Str::uuid();
                        $value_1 = [
                            "uuid" => $uuid,
                            "uuid_jenis_pelayanan" => $item1->uuid,
                            "no_urut" => $i + 1,
                            "kode" => $ar_kode[$i],
                            "nama_kelompok" => $ar_value[$i],
                            "uuid_created" => $user->uuid_profile,
                        ];
                        MasterKelompokUttp::create($value_1);
                    }
                } elseif ($nama_pelayanan == "Pengujian BDKT") {
                    $ar_kode = [
                        "BDKT",
                    ];
                    $ar_value = [
                        "Barang Dalam Keadaan Terbungkus (BDKT)",
                    ];
                    $car_value = count($ar_value);
                    for ($i = 0; $i < $car_value; $i++) {
                        $uuid = Str::uuid();
                        $value_1 = [
                            "uuid" => $uuid,
                            "uuid_jenis_pelayanan" => $item1->uuid,
                            "no_urut" => $i + 1,
                            "kode" => $ar_kode[$i],
                            "nama_kelompok" => $ar_value[$i],
                            "uuid_created" => $user->uuid_profile,
                        ];
                        MasterKelompokUttp::create($value_1);
                    }
                }
            }
        }
    }
}
