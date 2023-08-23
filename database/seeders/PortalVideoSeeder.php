<?php

namespace Database\Seeders;

use App\Models\PortalVideo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PortalVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // user
        $user = User::where("sub_role", "Admin Portal")->first();

        // cek postingan
        $cekUnduhan = PortalVideo::first();
        if ($cekUnduhan === null) {
            // GET POST
            $response = Http::get('https://api.slingacademy.com/v1/sample-data/blog-posts?limit=10');
            $posts = $response->object();
            foreach ($posts->blogs as $item) {
                // rand
                $rand = rand(0, 2);
                if ($rand == "0") {
                    $status = "Draft";
                    $url = "aKtb7Y3qOck";
                } elseif ($rand == "1") {
                    $status = "Published";
                    $url = "yygJTN-HcL0";
                } elseif ($rand == "2") {
                    $status = "Unpublish";
                    $url = "4JILPREpglY";
                }
                // create
                $value = [
                    "uuid" => Str::uuid(),
                    "judul" => $item->title,
                    "slug" => Str::slug($item->title),
                    "deskripsi" => $item->description,
                    "url" => $url,
                    "views" => rand(0, 10000),
                    "status" => $status,
                    "uuid_created" => $user->uuid_profile,
                ];
                // save
                PortalVideo::create($value);
            }
        }
    }
}
