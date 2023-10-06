<?php

namespace Database\Seeders;

use App\Helpers\CID;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Str;

class PerusahaanSeeder extends Seeder
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
        if ($cekPerusahaan === null) {
            // GET POST
            $response = Http::get('https://dummyjson.com/users?limit=60');
            $posts = $response->object();
            foreach ($posts->users as $item) {
                // rand
                $randJenis = rand(0, 1);
                if ($randJenis == "0") {
                    $jenis_perusahaan = "Perusahaan";
                } else {
                    $jenis_perusahaan = "Pemilik UTTP";
                }
                $verifikasi = rand(0, 3);
                if ($verifikasi == "0") {
                    // Baru Daftar
                    $verifikasi = "0";
                    $file_npwp = null;
                    $status = "1";
                } else if ($verifikasi == "1") {
                    // Perlu Verifikasi
                    $verifikasi = "0";
                    $file_npwp = $item->image;
                    $status = "1";
                } else if ($verifikasi == "2") {
                    // Aktif
                    $verifikasi = "1";
                    $file_npwp = $item->image;
                    $status = "1";
                } else if ($verifikasi == "3") {
                    // Ditangguhkan
                    $verifikasi = "1";
                    $file_npwp = $item->image;
                    $status = "0";
                }

                // create perusahaan
                $uuid_profile = Str::uuid();
                $value_1 = [
                    "uuid" => $uuid_profile,
                    "kode_perusahaan" => CID::genKodePerusahaan($jenis_perusahaan),
                    "jenis_perusahaan" => $jenis_perusahaan,
                    "nama_perusahaan" => "PT. " . $item->firstName . " " . $item->maidenName . " " . $item->lastName,
                    "nama_pic" => $item->maidenName,
                    "npwp" => rand(1000000000000000, 9000000000000000),
                    "email" => $item->email,
                    "no_telp_1" => str_replace([",", "+", "-"], [""], $item->phone),
                    "foto" => $item->image,
                    "file_npwp" => $file_npwp,
                    "verifikasi" => $verifikasi,
                    "status" => $status,
                    "uuid_created" => $user->uuid_profile,
                ];
                // save
                Perusahaan::create($value_1);

                // create user
                $uuid = Str::uuid();
                $value_2 = [
                    "uuid" => $uuid,
                    "uuid_profile" => $uuid_profile,
                    "username" => $item->email,
                    "password" => \bcrypt('123456'),
                    "role" => "Perusahaan",
                ];
                User::create($value_2);
            }
        }
    }
}
