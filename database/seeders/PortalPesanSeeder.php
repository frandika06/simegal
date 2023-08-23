<?php

namespace Database\Seeders;

use App\Models\PortalPesan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PortalPesanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // user
        $user = User::where("sub_role", "Admin Portal")->first();

        // cek postingan
        $cekUnduhan = PortalPesan::first();
        if ($cekUnduhan === null) {
            // GET POST
            $response1 = Http::get('https://api.slingacademy.com/v1/sample-data/blog-posts?limit=30');
            $posts = $response1->object();
            foreach ($posts->blogs as $item) {
                // https: //api.slingacademy.com/v1/sample-data/users/1
                $user_id = $item->user_id;
                $response2 = Http::get('https://api.slingacademy.com/v1/sample-data/users/' . $user_id);
                $users = $response2->object()->user;
                // rand
                $rand = rand(0, 1);
                if ($rand == "0") {
                    $status = "Unread";
                } elseif ($rand == "1") {
                    $status = "Readed";
                }
                // create
                $value = [
                    "uuid" => Str::uuid(),
                    "nama_lengkap" => $users->first_name . " " . $users->last_name,
                    "no_telp" => $users->phone,
                    "email" => $users->email,
                    "subjek" => $item->title,
                    "pesan" => $item->content_html,
                    "status" => $status,
                    "uuid_created" => $user->uuid_profile,
                ];
                // save
                PortalPesan::create($value);
            }
        }
    }
}
