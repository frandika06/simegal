<?php

namespace Database\Seeders;

use App\Models\PortalBanner;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PortalBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // user
        $user = User::where("sub_role", "Admin Portal")->first();

        // cek banner
        $cekPost = PortalBanner::first();
        if ($cekPost === null) {
            // GET BANNER
            $endpoint1 = "https://api.slingacademy.com/v1/sample-data/photos?limit=15";
            $response1 = Http::get($endpoint1);
            $images1 = $response1->object();
            $images1 = $images1->photos;
            foreach ($images1 as $item) {
                // rand
                $rand = rand(0, 2);
                if ($rand == "0") {
                    $status = "Draft";
                    $warna_text = "Dark";
                } elseif ($rand == "1") {
                    $status = "Published";
                    $warna_text = "Light";
                } elseif ($rand == "2") {
                    $status = "Unpublish";
                    $warna_text = "Dark";
                }
                // create
                $value = [
                    "uuid" => Str::uuid(),
                    "judul" => $item->title,
                    "deskripsi" => $item->description,
                    "warna_text" => $warna_text,
                    "thumbnails" => $item->url,
                    "status" => $status,
                    "uuid_created" => $user->uuid_profile,
                ];
                // save
                PortalBanner::create($value);
            }
        }
    }
}
