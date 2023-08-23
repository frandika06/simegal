<?php

namespace Database\Seeders;

use App\Models\PortalFAQ;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PortalFAQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // user
        $user = User::where("sub_role", "Admin Portal")->first();

        // cek postingan
        $cekUnduhan = PortalFAQ::first();
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
                    "judul" => $item->title,
                    "post" => $item->description,
                    "status" => $status,
                    "uuid_created" => $user->uuid_profile,
                ];
                // save
                PortalFAQ::create($value);
            }
        }
    }
}
