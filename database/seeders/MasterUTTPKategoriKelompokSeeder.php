<?php

namespace Database\Seeders;

use App\Models\MasterJenisPelayanan;
use App\Models\MasterKategoriKelompok;
use App\Models\MasterKelompokUttp;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MasterUTTPKategoriKelompokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // user
        $user = User::where("role", "Super Admin")->first();

        // cek master kp
        $cekMasterKP = MasterKategoriKelompok::first();
        if ($cekMasterKP === null) {
            // get JP
            $jp = MasterJenisPelayanan::get();
            foreach ($jp as $item1) {
                // get kuttp
                $uuid_jp = $item1->uuid;
                $nama_jp = $item1->nama_pelayanan;
                $kuttp = MasterKelompokUttp::whereUuidJp($uuid_jp)->get();
                foreach ($kuttp as $item2) {
                    $uuid_kelompok_uutp = $item2->uuid;
                    $kode_klpk = $item2->kode;
                    if ($nama_jp == "Tera" && $kode_klpk == "MT") {
                        // tera & MT
                        // Kategori 0 : Jenis UTTP
                        $ar_value_1 = [
                            "Timbangan Bobot Ingsut",
                            "Timbangan Sentisimal",
                            "Timbangan Pegas",
                            "Timbangan Meja",
                            "Timbangan Dacin",
                            "Neraca",
                            "Timbangan Elektronik",
                        ];
                        $car_value_1 = count($ar_value_1);
                        for ($i = 0; $i < $car_value_1; $i++) {
                            $value_1 = [
                                "uuid" => Str::uuid(),
                                "uuid_jp" => $uuid_jp,
                                "uuid_kelompok_uutp" => $uuid_kelompok_uutp,
                                "nama_kategori" => $ar_value_1[$i],
                                "kategori" => "0",
                                "uuid_created" => $user->uuid_profile,
                            ];
                            MasterKategoriKelompok::create($value_1);
                        }

                        // Kategori 1 : Alat Standar & Perlengkapannya
                        $ar_value_2 = [
                            "Anak Timbangan M2 20 kg",
                            "Anak Timbangan M2 10 kg",
                            "Anak Timbangan M2 5 kg",
                            "Anak Timbangan M2 2 kg",
                            "Anak Timbangan M2 1 kg",
                            "Anak Timbangan M1 1 set",
                            "Anak Timbangan M1 10 kg",
                            "Anak Timbangan M1 20 kg",
                            "Anak Timbangan F2 1 set",
                            "Anak Timbangan F2 10 kg",
                            "Anak Timbangan F2 20 kg",
                        ];
                        $car_value_2 = count($ar_value_2);
                        for ($i = 0; $i < $car_value_2; $i++) {
                            $value_2 = [
                                "uuid" => Str::uuid(),
                                "uuid_jp" => $uuid_jp,
                                "uuid_kelompok_uutp" => $uuid_kelompok_uutp,
                                "nama_kategori" => $ar_value_2[$i],
                                "kategori" => "1",
                                "uuid_created" => $user->uuid_profile,
                            ];
                            MasterKategoriKelompok::create($value_2);
                        }

                        // Kategori 2 : CTT
                        $ar_value_3 = [
                            "SL",
                            "SP",
                            "HP",
                            "H",
                            "J",
                            "JP",
                        ];
                        $car_value_3 = count($ar_value_3);
                        for ($i = 0; $i < $car_value_3; $i++) {
                            $value_3 = [
                                "uuid" => Str::uuid(),
                                "uuid_jp" => $uuid_jp,
                                "uuid_kelompok_uutp" => $uuid_kelompok_uutp,
                                "nama_kategori" => $ar_value_3[$i],
                                "kategori" => "2",
                                "uuid_created" => $user->uuid_profile,
                            ];
                            MasterKategoriKelompok::create($value_3);
                        }
                    } elseif ($nama_jp == "Tera" && $kode_klpk == "UAPV") {
                        // tera & UAPV
                        // Kategori 0 : Jenis UTTP
                        $ar_value_1 = [
                            "Bejana",
                            "Pompa Ukur BBM",
                            "Meter Air",
                            "Meter Kwh",
                            "Tangki Ukur Mobil",
                        ];
                        $car_value_1 = count($ar_value_1);
                        for ($i = 0; $i < $car_value_1; $i++) {
                            $value_1 = [
                                "uuid" => Str::uuid(),
                                "uuid_jp" => $uuid_jp,
                                "uuid_kelompok_uutp" => $uuid_kelompok_uutp,
                                "nama_kategori" => $ar_value_1[$i],
                                "kategori" => "0",
                                "uuid_created" => $user->uuid_profile,
                            ];
                            MasterKategoriKelompok::create($value_1);
                        }

                        // Kategori 1 : Alat Standar & Perlengkapannya
                        $ar_value_2 = [
                            "Bejana 10 L",
                            "Bejana 20 L",
                            "Bejana 200 L",
                            "Bejana 300 L",
                            "Bejana 5000 L",
                            "Tongkat Duga",
                            "Salib Ukur",
                            "Jangka Sorong",
                            "Stopwatch",
                        ];
                        $car_value_2 = count($ar_value_2);
                        for ($i = 0; $i < $car_value_2; $i++) {
                            $value_2 = [
                                "uuid" => Str::uuid(),
                                "uuid_jp" => $uuid_jp,
                                "uuid_kelompok_uutp" => $uuid_kelompok_uutp,
                                "nama_kategori" => $ar_value_2[$i],
                                "kategori" => "1",
                                "uuid_created" => $user->uuid_profile,
                            ];
                            MasterKategoriKelompok::create($value_2);
                        }

                        // Kategori 2 : CTT
                        $ar_value_3 = [
                            "SL",
                            "SP",
                            "HP",
                            "H",
                            "J",
                            "JP",
                        ];
                        $car_value_3 = count($ar_value_3);
                        for ($i = 0; $i < $car_value_3; $i++) {
                            $value_3 = [
                                "uuid" => Str::uuid(),
                                "uuid_jp" => $uuid_jp,
                                "uuid_kelompok_uutp" => $uuid_kelompok_uutp,
                                "nama_kategori" => $ar_value_3[$i],
                                "kategori" => "2",
                                "uuid_created" => $user->uuid_profile,
                            ];
                            MasterKategoriKelompok::create($value_3);
                        }
                    } elseif ($nama_jp == "Tera Ulang" && $kode_klpk == "MT") {
                        // tera ulang & MT
                        // Kategori 0 : Jenis UTTP
                        $ar_value_1 = [
                            "Timbangan Bobot Ingsut",
                            "Timbangan Sentisimal",
                            "Timbangan Pegas",
                            "Timbangan Meja",
                            "Timbangan Dacin",
                            "Neraca",
                            "Timbangan Elektronik",
                        ];
                        $car_value_1 = count($ar_value_1);
                        for ($i = 0; $i < $car_value_1; $i++) {
                            $value_1 = [
                                "uuid" => Str::uuid(),
                                "uuid_jp" => $uuid_jp,
                                "uuid_kelompok_uutp" => $uuid_kelompok_uutp,
                                "nama_kategori" => $ar_value_1[$i],
                                "kategori" => "0",
                                "uuid_created" => $user->uuid_profile,
                            ];
                            MasterKategoriKelompok::create($value_1);
                        }

                        // Kategori 1 : Alat Standar & Perlengkapannya
                        $ar_value_2 = [
                            "Anak Timbangan M2 20 kg",
                            "Anak Timbangan M2 10 kg",
                            "Anak Timbangan M2 5 kg",
                            "Anak Timbangan M2 2 kg",
                            "Anak Timbangan M2 1 kg",
                            "Anak Timbangan M1 1 set",
                            "Anak Timbangan M1 10 kg",
                            "Anak Timbangan M1 20 kg",
                            "Anak Timbangan F2 1 set",
                            "Anak Timbangan F2 10 kg",
                            "Anak Timbangan F2 20 kg",
                        ];
                        $car_value_2 = count($ar_value_2);
                        for ($i = 0; $i < $car_value_2; $i++) {
                            $value_2 = [
                                "uuid" => Str::uuid(),
                                "uuid_jp" => $uuid_jp,
                                "uuid_kelompok_uutp" => $uuid_kelompok_uutp,
                                "nama_kategori" => $ar_value_2[$i],
                                "kategori" => "1",
                                "uuid_created" => $user->uuid_profile,
                            ];
                            MasterKategoriKelompok::create($value_2);
                        }

                        // Kategori 2 : CTT
                        $ar_value_3 = [
                            "SL",
                            "SP",
                            "HP",
                            "H",
                            "J",
                            "JP",
                        ];
                        $car_value_3 = count($ar_value_3);
                        for ($i = 0; $i < $car_value_3; $i++) {
                            $value_3 = [
                                "uuid" => Str::uuid(),
                                "uuid_jp" => $uuid_jp,
                                "uuid_kelompok_uutp" => $uuid_kelompok_uutp,
                                "nama_kategori" => $ar_value_3[$i],
                                "kategori" => "2",
                                "uuid_created" => $user->uuid_profile,
                            ];
                            MasterKategoriKelompok::create($value_3);
                        }
                    } elseif ($nama_jp == "Tera Ulang" && $kode_klpk == "UAPV") {
                        // tera ulang & UAPV
                        // Kategori 0 : Jenis UTTP
                        $ar_value_1 = [
                            "Bejana",
                            "Pompa Ukur BBM",
                            "Meter Air",
                            "Meter Kwh",
                            "Tangki Ukur Mobil",
                        ];
                        $car_value_1 = count($ar_value_1);
                        for ($i = 0; $i < $car_value_1; $i++) {
                            $value_1 = [
                                "uuid" => Str::uuid(),
                                "uuid_jp" => $uuid_jp,
                                "uuid_kelompok_uutp" => $uuid_kelompok_uutp,
                                "nama_kategori" => $ar_value_1[$i],
                                "kategori" => "0",
                                "uuid_created" => $user->uuid_profile,
                            ];
                            MasterKategoriKelompok::create($value_1);
                        }

                        // Kategori 1 : Alat Standar & Perlengkapannya
                        $ar_value_2 = [
                            "Bejana 10 L",
                            "Bejana 20 L",
                            "Bejana 200 L",
                            "Bejana 300 L",
                            "Bejana 5000 L",
                            "Tongkat Duga",
                            "Salib Ukur",
                            "Jangka Sorong",
                            "Stopwatch",
                        ];
                        $car_value_2 = count($ar_value_2);
                        for ($i = 0; $i < $car_value_2; $i++) {
                            $value_2 = [
                                "uuid" => Str::uuid(),
                                "uuid_jp" => $uuid_jp,
                                "uuid_kelompok_uutp" => $uuid_kelompok_uutp,
                                "nama_kategori" => $ar_value_2[$i],
                                "kategori" => "1",
                                "uuid_created" => $user->uuid_profile,
                            ];
                            MasterKategoriKelompok::create($value_2);
                        }

                        // Kategori 2 : CTT
                        $ar_value_3 = [
                            "SL",
                            "SP",
                            "HP",
                            "H",
                            "J",
                            "JP",
                        ];
                        $car_value_3 = count($ar_value_3);
                        for ($i = 0; $i < $car_value_3; $i++) {
                            $value_3 = [
                                "uuid" => Str::uuid(),
                                "uuid_jp" => $uuid_jp,
                                "uuid_kelompok_uutp" => $uuid_kelompok_uutp,
                                "nama_kategori" => $ar_value_3[$i],
                                "kategori" => "2",
                                "uuid_created" => $user->uuid_profile,
                            ];
                            MasterKategoriKelompok::create($value_3);
                        }
                    } elseif ($nama_jp == "Pengujian BDKT" && $kode_klpk == "BDKT") {
                        // Pengujian BDKT & BDKT
                        // Kategori 0 : Jenis UTTP
                        $ar_value_1 = [
                            "BDKT Satuan Massa",
                            "BDKT Satuan Volume",
                        ];
                        $car_value_1 = count($ar_value_1);
                        for ($i = 0; $i < $car_value_1; $i++) {
                            $value_1 = [
                                "uuid" => Str::uuid(),
                                "uuid_jp" => $uuid_jp,
                                "uuid_kelompok_uutp" => $uuid_kelompok_uutp,
                                "nama_kategori" => $ar_value_1[$i],
                                "kategori" => "0",
                                "uuid_created" => $user->uuid_profile,
                            ];
                            MasterKategoriKelompok::create($value_1);
                        }

                        // Kategori 1 : Alat Standar & Perlengkapannya
                        $ar_value_2 = [
                            "Timbangan Elektronik",
                        ];
                        $car_value_2 = count($ar_value_2);
                        for ($i = 0; $i < $car_value_2; $i++) {
                            $value_2 = [
                                "uuid" => Str::uuid(),
                                "uuid_jp" => $uuid_jp,
                                "uuid_kelompok_uutp" => $uuid_kelompok_uutp,
                                "nama_kategori" => $ar_value_2[$i],
                                "kategori" => "1",
                                "uuid_created" => $user->uuid_profile,
                            ];
                            MasterKategoriKelompok::create($value_2);
                        }
                    }
                }
            }
        }
    }
}
