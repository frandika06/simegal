<?php

namespace App\Http\Controllers\ApiBase\ApiAdmin\SettingsApps\auth;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\SysLogAktifitas;
use App\Models\SysLogin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiSetAppsProfileController extends Controller
{
    //index
    public function index()
    {
        // auth
        $auth = auth()->user();
        $uuid = $auth->uuid_profile;

        // profile
        $profile = Pegawai::with("RelUser")->findOrFail($uuid);
        $profile['foto'] = CID::pp($profile->foto);

        // get data log
        $uuid_profile = $profile->uuid;
        $logs_login = SysLogin::whereUuidProfile($uuid_profile)
            ->whereMonth("created_at", date('m'))
            ->orderBy("created_at", "DESC")
            ->get();
        $logs_aktifitas = SysLogAktifitas::whereUuidProfile($uuid_profile)
            ->whereMonth("created_at", date('m'))
            ->orderBy("created_at", "DESC")
            ->get();

        // data
        $data = [
            "profile" => $profile,
            "logs_login" => $logs_login,
            "logs_aktifitas" => $logs_aktifitas,
        ];
        // response
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }

    // update
    public function update(Request $request)
    {
        // auth
        $auth = auth()->user();
        $uuid = $auth->uuid_profile;
        $path_form = $request->path_form;
        if ($path_form == "profile") {
            return $this->updateProfile($request, $uuid);
        } elseif ($path_form == "keamanan") {
            return $this->updateKeamanan($request, $uuid);
        } else {
            return abort(404);
        }
    }
    // update profile
    private function updateProfile($request, $uuid)
    {
        // auth
        $auth = auth()->user();
        $uuid_profile = $auth->uuid_profile;
        $data = Pegawai::findOrFail($uuid);

        // validate
        $validator = Validator::make($request->all(), [
            "nama_lengkap" => "required|string|max:100",
            "nip" => "required|string|max:100",
            "pangkat_golongan" => "required|string|max:100",
            "jabatan" => "required|string|max:100",
            "jenis_kelamin" => "required|string|max:100",
            "email" => "required|string|max:100",
            "no_telp" => "required|string|max:15",
        ]);
        // response validasi
        $response = [
            "status" => false,
            "message" => "Validation Error!!",
            "errors" => $validator->errors(),
            "request" => $request->all(),
        ];
        if ($validator->fails()) {
            return response()->json($response, 422);
        }

        //Submit Register
        $email = $request->email;
        // cek email
        if ($email != $data->email) {
            $cekEmail = Pegawai::whereEmail($email)->first();
            if ($cekEmail !== null) {
                // ada Pegawai
                // response
                $response = [
                    "status" => false,
                    "message" => "Email Sudah Digunakan Oleh Pegawai Lain, Mohon Cek Kembali Alamat Email!",
                    "request" => $request->all(),
                ];
                return response()->json($response, 422);
            }
        }

        // value Pegawai
        $value_1 = [
            "nama_lengkap" => $request->nama_lengkap,
            "nip" => $request->nip,
            "pangkat_golongan" => $request->pangkat_golongan,
            "jabatan" => $request->jabatan,
            "jenis_kelamin" => $request->jenis_kelamin,
            "email" => Str::lower($email),
            "no_telp" => $request->no_telp,
            "uuid_updated" => $uuid_profile,
        ];

        // foto
        $path = "pegawai/" . $uuid;
        if ($request->hasFile('foto')) {
            $foto = CID::UpImg($request, "foto", $path);
            if ($foto == "0") {
                $response = [
                    "status" => false,
                    "message" => "Gagal Menyimpan Data, Foto Tidak Sesuai Format!",
                    "request" => $request->all(),
                ];
                return response()->json($response, 422);
            }
            $value_1['foto'] = $foto;
        }

        // save
        $save_1 = Pegawai::whereUuid($uuid)->update($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("pegawai"),
                "uuid" => array($uuid),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Settings Apps",
                "subjek" => "Berhasil Mengubah Profile Pegawai: " . $request->nama_lengkap . " - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "mobile",
                "dashboard" => "0",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            $response = [
                "status" => true,
                "message" => "Berhasil Mengubah Profile Pegawai: " . $request->nama_lengkap,
            ];
            return response()->json($response, 201);
        } else {
            $response = [
                "status" => false,
                "message" => "Gagal Mengubah Profile Pegawai: " . $request->nama_lengkap,
                "request" => $request->all(),
            ];
            return response()->json($response, 422);
        }
    }
    // update keamanan
    private function updateKeamanan($request, $uuid_pegawai)
    {
        // auth
        $auth = auth()->user();
        $uuid_profile = $auth->uuid_profile;
        $data = Pegawai::findOrFail($uuid_pegawai);
        $username = $data->RelUser->username;

        // validate
        $validator = Validator::make($request->all(), [
            "username" => "required|string|max:100",
            "old_password" => "required|string|max:100",
            "new_password" => "required|string|max:100",
        ]);
        // response validasi
        $response = [
            "status" => false,
            "message" => "Validation Error!!",
            "errors" => $validator->errors(),
            "request" => $request->all(),
        ];
        if ($validator->fails()) {
            return response()->json($response, 422);
        }

        // value_1
        $new_username = $request->username;
        $old_password = $request->old_password;
        $new_password = $request->new_password;

        // cek password lama
        if (!Hash::check($old_password, $data->RelUser->password)) {
            // password lama salah
            $response = [
                "status" => false,
                "message" => "Password Lama Salah!",
                "request" => $request->all(),
            ];
            return response()->json($response, 422);
        }

        // cek username
        if ($new_username != $username) {
            // validate
            $validator = Validator::make($request->all(), [
                "username" => "required|unique:users,username|max:100",
            ]);
            // response validasi
            $response = [
                "status" => false,
                "message" => "Validation Error!!",
                "errors" => $validator->errors(),
                "request" => $request->all(),
            ];
            if ($validator->fails()) {
                return response()->json($response, 422);
            }
            $username = $new_username;
        }

        // value
        $value_1 = [
            "username" => $username,
            "password" => \bcrypt($new_password),
            "uuid_updated" => $uuid_profile,
        ];

        // save
        $save_1 = User::whereUuidProfile($uuid_pegawai)->update($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("users"),
                "uuid" => array($data->RelUser->uuid),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Settings Apps",
                "subjek" => "Berhasil Mengubah Akun Login Pegawai " . $data->nama_lengkap . " - " . $data->uuid,
                "aktifitas" => $aktifitas,
                "device" => "mobile",
                "dashboard" => "0",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            $response = [
                "status" => true,
                "message" => "Berhasil Mengubah Keamanan Akun.",
            ];
            return response()->json($response, 201);
        } else {
            $response = [
                "status" => false,
                "message" => "Gagal Mengubah Keamanan Akun.",
                "request" => $request->all(),
            ];
            return response()->json($response, 422);
        }
    }
}