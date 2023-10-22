<?php

namespace Database\Seeders;

use App\Helpers\CID;
use App\Models\AlamatPerusahaan;
use App\Models\PermohonanPeneraan;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermohonanPeneraanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // user
        $user = User::where("username", "sa@mail.com")->first();

        // cek perusahaan
        $cekPerusahaan = Perusahaan::first();
        if ($cekPerusahaan !== null) {
            // get data perusahaan
            $perusahaan = Perusahaan::get();
            foreach ($perusahaan as $item1) {
                $uuid_perusahaan = $item1->uuid;
                // cek alamat
                $alamat = AlamatPerusahaan::whereUuidPerusahaan($uuid_perusahaan)->get();
                foreach ($alamat as $item) {
                    // rand jenis_pengujian
                    $randJP = rand(1, 3);
                    if ($randJP == "1") {
                        $jp = "Tera";
                    } elseif ($randJP == "2") {
                        $jp = "Tera Ulang";
                    } elseif ($randJP == "3") {
                        $jp = "Pengujian BDKT";
                    }

                    // rand lokasi_peneraan
                    $randLokasi = rand(1, 2);
                    if ($randLokasi == "1") {
                        $lokasi_peneraan = "Dalam Kantor Metrologi";
                        $uuid_alamat = null;
                    } elseif ($randLokasi == "2") {
                        $lokasi_peneraan = "Luar Kantor Metrologi";
                        $uuid_alamat = $item->uuid;
                    }

                    // rand status
                    $randStatus = rand(1, 4);
                    if ($randStatus == "1") {
                        $status = "Baru";
                        $pesan_penolakan = null;
                    } elseif ($randStatus == "2") {
                        $status = "Diproses";
                        $pesan_penolakan = null;
                    } elseif ($randStatus == "3") {
                        $status = "Ditolak";
                        $pesan_penolakan = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
                    } elseif ($randStatus == "4") {
                        $status = "Selesai";
                        $pesan_penolakan = null;
                    }

                    // value
                    $kode_permohonan = CID::genKodePermohonan($jp);
                    $value_1 = [
                        "uuid" => Str::uuid(),
                        "uuid_perusahaan" => $uuid_perusahaan,
                        "kode_permohonan" => $kode_permohonan,
                        "jenis_pengujian" => $jp,
                        "nomor_surat_permohonan" => rand(0, 1000) . "/" . CID::gencode(1) . "/" . CID::bln2Romawi(date('n')) . "/" . date('Y'),
                        "file_surat_permohonan" => "https://www.africau.edu/images/default/sample.pdf",
                        "tanggal_permohonan" => date('Y-m-d'),
                        "lokasi_peneraan" => $lokasi_peneraan,
                        "uuid_alamat" => $uuid_alamat,
                        "status" => $status,
                        "uuid_verifikator" => $user->uuid_profile,
                        "pesan_penolakan" => $pesan_penolakan,
                        "tanggal_verifikasi" => date('Y-m-d H:i:s'),
                    ];

                    // save
                    PermohonanPeneraan::create($value_1);
                }
            }
        }
    }
}
