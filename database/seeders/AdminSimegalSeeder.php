<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AdminSimegalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // cek user
        $cekUser = User::first();
        if ($cekUser === null) {
            // create user
            // 1. Admin System
            $uuid_root = Str::uuid();
            $value_adm_root = [
                "uuid" => $uuid_root,
                "nama_lengkap" => "Admin System",
                "nip" => "0",
                "jabatan" => "Admin System",
                "jenis_kelamin" => "L",
                "email" => "admin@mail.com",
                "no_telp" => "081510679515",
                "status_pegawai" => "Non ASN",
                "uuid_created" => $uuid_root,
            ];
            // create pegawai
            Pegawai::create($value_adm_root);
            $value_user_root = [
                "uuid" => Str::uuid(),
                "uuid_profile" => $uuid_root,
                "username" => "admin@mail.com",
                "password" => \bcrypt('admin1234'),
                "role" => "Admin System",
                "uuid_created" => $uuid_root,
            ];
            // create user
            User::create($value_user_root);

            // 2. Super Admin
            $uuid_root = Str::uuid();
            $value_adm_root = [
                "uuid" => $uuid_root,
                "nama_lengkap" => "Super Admin",
                "nip" => "0",
                "jabatan" => "Super Admin",
                "jenis_kelamin" => "L",
                "email" => "sa@mail.com",
                "no_telp" => "081510679515",
                "status_pegawai" => "Non ASN",
                "uuid_created" => $uuid_root,
            ];
            // create pegawai
            Pegawai::create($value_adm_root);
            $value_user_root = [
                "uuid" => Str::uuid(),
                "uuid_profile" => $uuid_root,
                "username" => "sa@mail.com",
                "password" => \bcrypt('admin1234'),
                "role" => "Super Admin",
                "uuid_created" => $uuid_root,
            ];
            // create user
            User::create($value_user_root);

            // 3. Admin Portal
            $uuid_root = Str::uuid();
            $value_adm_root = [
                "uuid" => $uuid_root,
                "nama_lengkap" => "Admin Portal",
                "nip" => "0",
                "jabatan" => "Admin Portal",
                "jenis_kelamin" => "L",
                "email" => "adminportal@mail.com",
                "no_telp" => "081510679515",
                "status_pegawai" => "Non ASN",
                "uuid_created" => $uuid_root,
            ];
            // create pegawai
            Pegawai::create($value_adm_root);
            $value_user_root = [
                "uuid" => Str::uuid(),
                "uuid_profile" => $uuid_root,
                "username" => "adminportal@mail.com",
                "password" => \bcrypt('admin1234'),
                "role" => "Pegawai",
                "sub_role" => "Admin Portal",
                "uuid_created" => $uuid_root,
            ];
            // create user
            User::create($value_user_root);

            // 4. Pegawai
            $response = Http::get('https://dummyjson.com/users?limit=150&skip=60');
            $dataApi = $response->object();
            foreach ($dataApi->users as $item) {
                // $randSubRole = rand(1, 4);
                // if ($randSubRole == "1") {
                //     $subRole = "Admin Aplikasi";
                // } elseif ($randSubRole == "2") {
                //     $subRole = "Petugas";
                // } elseif ($randSubRole == "3") {
                //     $subRole = "Ketua Tim";
                // } elseif ($randSubRole == "4") {
                //     $subRole = "Verifikator";
                // }

                $randSubSubRole = rand(1, 3);
                if ($randSubSubRole == "1") {
                    $subSubRole = "Ketua Tim Pelayanan";
                } elseif ($randSubSubRole == "2") {
                    $subSubRole = "Ketua Tim Pengawasan";
                } elseif ($randSubSubRole == "3") {
                    $subSubRole = "Ketua Tim Bina SDM";
                }

                if ($item->email == "hfasey1t@home.pl") {
                    $subRole = "Admin Aplikasi";
                } elseif ($item->email == "hyaknov2i@hhs.gov") {
                    $subRole = "Admin Pengawasan";
                } elseif ($item->email == "gbarhams1u@cnet.com") {
                    $subRole = "Petugas";
                } elseif ($item->email == "hollet1s@trellian.com") {
                    $subRole = "Verifikator";
                } elseif ($item->email == "eburras1q@go.com") {
                    $subRole = "Ketua Tim";
                    $subSubRole = "Ketua Tim Pelayanan";
                } elseif ($item->email == "cmasurel1x@baidu.com") {
                    $subRole = "Ketua Tim";
                    $subSubRole = "Ketua Tim Pengawasan";
                } elseif ($item->email == "wfeldon20@netlog.com") {
                    $subRole = "Ketua Tim";
                    $subSubRole = "Ketua Tim Bina SDM";
                } else {
                    $subRole = "Petugas";
                }

                $randStatusPegawai = rand(1, 2);
                if ($randStatusPegawai == "1") {
                    $status_pegawai = "ASN";
                    $nip = rand(100000000000, 999999999999);
                } elseif ($randStatusPegawai == "2") {
                    $status_pegawai = "Non ASN";
                    $nip = "0";
                }

                if ($subRole == "Ketua Tim") {
                    $subSubRole = $subSubRole;
                    $status_pegawai = "ASN";
                    $nip = rand(100000000000, 999999999999);
                } else {
                    $subSubRole = null;
                }

                // value
                $uuid_root = Str::uuid();
                $value_adm_root = [
                    "uuid" => $uuid_root,
                    "nama_lengkap" => $item->firstName . " " . $item->lastName,
                    "nip" => $nip,
                    "jabatan" => $subRole,
                    "jenis_kelamin" => "L",
                    "email" => $item->email,
                    "no_telp" => $item->phone,
                    "status_pegawai" => $status_pegawai,
                    "uuid_created" => $uuid_root,
                ];
                // create pegawai
                Pegawai::create($value_adm_root);
                $value_user_root = [
                    "uuid" => Str::uuid(),
                    "uuid_profile" => $uuid_root,
                    "username" => $item->email,
                    "password" => \bcrypt('admin1234'),
                    "role" => "Pegawai",
                    "sub_role" => $subRole,
                    "sub_sub_role" => $subSubRole,
                    "uuid_created" => $uuid_root,
                ];
                // create user
                User::create($value_user_root);
            }

            // 5. Kepala Bidang
            $uuid_root = Str::uuid();
            $value_adm_root = [
                "uuid" => $uuid_root,
                "nama_lengkap" => "Kepala Bidang",
                "nip" => rand(100000000000, 999999999999),
                "jabatan" => "Kepala Bidang",
                "jenis_kelamin" => "L",
                "email" => "kepalabidang@mail.com",
                "no_telp" => "081510679515",
                "status_pegawai" => "ASN",
                "uuid_created" => $uuid_root,
            ];
            // create pegawai
            Pegawai::create($value_adm_root);
            $value_user_root = [
                "uuid" => Str::uuid(),
                "uuid_profile" => $uuid_root,
                "username" => "kepalabidang@mail.com",
                "password" => \bcrypt('admin1234'),
                "role" => "Kepala Bidang",
                "uuid_created" => $uuid_root,
            ];
            // create user
            User::create($value_user_root);

            // 6. Kepala Dinas
            $uuid_root = Str::uuid();
            $value_adm_root = [
                "uuid" => $uuid_root,
                "nama_lengkap" => "Kepala Dinas",
                "nip" => rand(100000000000, 999999999999),
                "jabatan" => "Kepala Dinas",
                "jenis_kelamin" => "L",
                "email" => "kepaladinas@mail.com",
                "no_telp" => "081510679515",
                "status_pegawai" => "ASN",
                "uuid_created" => $uuid_root,
            ];
            // create pegawai
            Pegawai::create($value_adm_root);
            $value_user_root = [
                "uuid" => Str::uuid(),
                "uuid_profile" => $uuid_root,
                "username" => "kepaladinas@mail.com",
                "password" => \bcrypt('admin1234'),
                "role" => "Kepala Dinas",
                "uuid_created" => $uuid_root,
            ];
            // create user
            User::create($value_user_root);
        }
    }
}
