<?php

namespace Database\Seeders;

use App\Models\PortalUnduhan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PortalUnduhanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // user
        $user = User::where("sub_role", "Admin Portal")->first();

        // cek postingan
        $cekUnduhan = PortalUnduhan::first();
        if ($cekUnduhan === null) {
            // GET POST
            $response = Http::get('https://api.slingacademy.com/v1/sample-data/blog-posts?limit=30');
            $posts = $response->object();
            foreach ($posts->blogs as $item) {
                // rand
                $rand = rand(0, 2);
                if ($rand == "0") {
                    $status = "Draft";
                } elseif ($rand == "1") {
                    $status = "Published";
                } elseif ($rand == "2") {
                    $status = "Unpublish";
                }
                // create
                $value = [
                    "uuid" => Str::uuid(),
                    "nomor" => "",
                    "kategori_file" => "berita," . $item->category,
                    "judul" => $item->title,
                    "slug" => Str::slug($item->title),
                    "deskripsi" => $item->description,
                    "tanggal" => date('Y-m-d H:i:s', strtotime($item->created_at)),
                    "url" => 'sistem/sample-unduhan.pdf',
                    "tipe" => "pdf",
                    "size" => rand(1000, 1000000),
                    "views" => rand(0, 10000),
                    "downloads" => rand(0, 10000),
                    "status" => $status,
                    "uuid_created" => $user->uuid_profile,
                ];
                // save
                PortalUnduhan::create($value);
            }
        }
    }
}
