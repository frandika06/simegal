<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Database\Seeder;
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
                "jabatan" => "Admin System",
                "jenis_kelamin" => "L",
                "email" => "admin@mail.com",
                "no_telp" => "081510679515",
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
                "jabatan" => "Super Admin",
                "jenis_kelamin" => "L",
                "email" => "sa@mail.com",
                "no_telp" => "081510679515",
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
                "jabatan" => "Admin Portal",
                "jenis_kelamin" => "L",
                "email" => "adminportal@mail.com",
                "no_telp" => "081510679515",
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
        }
    }
}
