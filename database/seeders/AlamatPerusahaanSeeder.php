<?php

namespace Database\Seeders;

use App\Models\AlamatPerusahaan;
use App\Models\Perusahaan;
use App\Models\User;
use App\Models\WilDesa;
use App\Models\WilKecamatan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AlamatPerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // user
        $user = User::where("sub_role", "Admin Portal")->first();

        // cek perusahaan
        $cekPerusahaan = Perusahaan::first();
        if ($cekPerusahaan !== null) {
            // get data perusahaan
            $perusahaan = Perusahaan::get();
            foreach ($perusahaan as $item1) {
                $uuid_perusahaan = $item1->uuid;
                // cek alamat
                $cekAlamat = AlamatPerusahaan::whereUuidPerusahaan($uuid_perusahaan)->count();
                if ($cekAlamat < 5) {
                    // kecamatan
                    $WilKecamatan = WilKecamatan::where("regency_id", "3603")->orderBy("name", "ASC")->get();
                    $idKec1 = rand(0, 5);
                    $district_id[0] = $WilKecamatan[$idKec1]['id'];
                    $idKec2 = rand(6, 10);
                    $district_id[1] = $WilKecamatan[$idKec2]['id'];
                    $idKec3 = rand(11, 15);
                    $district_id[2] = $WilKecamatan[$idKec3]['id'];
                    $idKec4 = rand(16, 20);
                    $district_id[3] = $WilKecamatan[$idKec4]['id'];
                    $idKec5 = rand(21, 28);
                    $district_id[4] = $WilKecamatan[$idKec5]['id'];

                    // desa
                    $WilDesa1 = WilDesa::where("district_id", $district_id[0])->orderBy("name", "ASC")->get();
                    $WilDesa2 = WilDesa::where("district_id", $district_id[1])->orderBy("name", "ASC")->get();
                    $WilDesa3 = WilDesa::where("district_id", $district_id[2])->orderBy("name", "ASC")->get();
                    $WilDesa4 = WilDesa::where("district_id", $district_id[3])->orderBy("name", "ASC")->get();
                    $WilDesa5 = WilDesa::where("district_id", $district_id[4])->orderBy("name", "ASC")->get();
                    $idDesa1 = rand(0, (count($WilDesa1) - 1));
                    $village_id[0] = $WilDesa1[$idDesa1]['id'];
                    $idDesa2 = rand(0, (count($WilDesa2) - 1));
                    $village_id[1] = $WilDesa2[$idDesa2]['id'];
                    $idDesa3 = rand(0, (count($WilDesa3) - 1));
                    $village_id[2] = $WilDesa3[$idDesa3]['id'];
                    $idDesa4 = rand(0, (count($WilDesa4) - 1));
                    $village_id[3] = $WilDesa4[$idDesa4]['id'];
                    $idDesa5 = rand(0, (count($WilDesa5) - 1));
                    $village_id[4] = $WilDesa5[$idDesa5]['id'];

                    // value
                    $cFor = count($district_id);
                    for ($i = 0; $i < $cFor; $i++) {
                        // cek alamat default
                        $cekAlamatDefault = AlamatPerusahaan::whereUuidPerusahaan($uuid_perusahaan)->first();
                        if ($cekAlamatDefault === null) {
                            $default = "1";
                        } else {
                            $default = "0";
                        }

                        $uuid = Str::uuid();
                        $value_1 = [
                            "uuid" => $uuid,
                            "uuid_perusahaan" => $uuid_perusahaan,
                            "province_id" => "36",
                            "regency_id" => "3603",
                            "district_id" => $district_id[$i],
                            "village_id" => $village_id[$i],
                            "alamat" => "Jl. Lorem Ipsum Dolor, No. " . rand(0, 100),
                            "rt" => rand(0, 100),
                            "rw" => rand(0, 50),
                            "kode_pos" => rand(10000, 19999),
                            "default" => $default,
                            "uuid_created" => $uuid_perusahaan,
                        ];

                        // save
                        AlamatPerusahaan::create($value_1);
                    }
                }
            }
        }
    }
}
