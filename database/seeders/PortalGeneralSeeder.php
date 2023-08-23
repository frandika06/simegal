<?php

namespace Database\Seeders;

use App\Models\PortalKategori;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PortalGeneralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // user
        $user = User::where("sub_role", "Admin Portal")->first();

        /*
        | GENERATE MASTER KATEGORI
         */
        $cekKategori = PortalKategori::first();
        if ($cekKategori === null) {
            // create kategori
            $nama = [
                "Berita",
                "Artikel",
                "Surat Edaran",
                "Regulasi",
            ];
            $jenis = [
                "Postingan",
                "Postingan",
                "Unduhan",
                "Unduhan",
            ];
            $cnama = count($nama);
            for ($i = 0; $i < $cnama; $i++) {
                $value = [
                    "uuid" => Str::uuid(),
                    "nama" => $nama[$i],
                    "slug" => Str::slug($nama[$i]),
                    "jenis" => $jenis[$i],
                    "uuid_created" => $user->uuid_profile,
                ];
                PortalKategori::create($value);
            }
        }
    }
}
