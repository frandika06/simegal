<?php

namespace Database\Seeders;

use App\Models\PortalPage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PortalPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // user
        $user = User::where("sub_role", "Admin Portal")->first();

        // cek postingan
        $cekPost = PortalPage::first();
        if ($cekPost === null) {
            // GET POST
            $no = 1;
            $response = Http::get('https://api.slingacademy.com/v1/sample-data/blog-posts?limit=2');
            $posts = $response->object();
            foreach ($posts->blogs as $item) {
                // rand
                $rand = rand(0, 2);
                if ($rand == "0") {
                    $status = "Published";
                } elseif ($rand == "1") {
                    $status = "Published";
                } elseif ($rand == "2") {
                    $status = "Published";
                }
                if ($no == "1") {
                    $judul = "Layanan Tera / Tera Ulang";
                    $slug = Str::slug($judul);
                } elseif ($no == "2") {
                    $judul = "Tentang Kami";
                    $slug = Str::slug($judul);
                } else {
                    $judul = $item->title;
                    $slug = Str::slug($item->title);
                }

                // create
                $value = [
                    "uuid" => Str::uuid(),
                    "judul" => $judul,
                    "slug" => $slug,
                    "deskripsi" => $item->description,
                    "post" => $item->content_html,
                    "thumbnails" => $item->photo_url,
                    "views" => rand(0, 10000),
                    "status" => $status,
                    "uuid_created" => $user->uuid_profile,
                ];
                // save
                PortalPage::create($value);
                $no++;
            }
        }
    }
}
