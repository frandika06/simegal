<?php

namespace Database\Seeders;

use App\Models\PortalDataGaleri;
use App\Models\PortalGaleri;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PortalGaleriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // user
        $user = User::where("sub_role", "Admin Portal")->first();

        // cek galeri
        $cekGaleri = PortalGaleri::first();
        if ($cekGaleri === null) {
            $no = 0;
            $endpoint = "https://api.slingacademy.com/v1/sample-data/blog-posts?limit=30";
            $response = Http::get($endpoint);
            $posts = $response->object();
            $data = $posts->blogs;
            foreach ($data as $item1) {
                // rand
                $rand = rand(0, 2);
                if ($rand == "0") {
                    $status = "Draft";
                } elseif ($rand == "1") {
                    $status = "Published";
                } elseif ($rand == "2") {
                    $status = "Unpublish";
                }
                // create galeri
                $uuid_galeri = Str::uuid();
                $value_1 = [
                    "uuid" => $uuid_galeri,
                    "judul" => $item1->title,
                    "slug" => Str::slug($item1->title),
                    "deskripsi" => $item1->description,
                    "views" => rand(0, 10000),
                    "status" => $status,
                    "uuid_created" => $user->uuid_profile,
                ];
                $save_1 = PortalGaleri::create($value_1);
                if ($save_1) {
                    // create data galeri
                    $endpoint1 = "https://api.slingacademy.com/v1/sample-data/photos?offset=" . $no . "&limit=5";
                    $response1 = Http::get($endpoint1);
                    $images1 = $response1->object();
                    $images1 = $images1->photos;
                    foreach ($images1 as $item2) {
                        $value_2 = [
                            "uuid" => Str::uuid(),
                            "uuid_galeri" => $uuid_galeri,
                            "url" => $item2->url,
                            "size" => rand(100, 10000),
                            "uuid_created" => $user->uuid_profile,
                        ];
                        PortalDataGaleri::create($value_2);
                    }
                }
                // kelipatan 5
                $no += 4;
            }
        }
    }
}
