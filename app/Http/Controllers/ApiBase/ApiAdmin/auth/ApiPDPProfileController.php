<?php

namespace App\Http\Controllers\ApiBase\ApiAdmin\auth;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\AlamatPerusahaan;
use App\Models\Perusahaan;
use App\Models\SysLogAktifitas;
use App\Models\SysLogin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiPDPProfileController extends Controller
{
    // index
    public function index(Request $request)
    {
        // auth
        $auth = auth()->user();
        $profile = $auth->RelPerusahaan;

        // get data alamat
        $alamatPerusahaan = AlamatPerusahaan::whereUuidPerusahaan($profile->uuid)
            ->orderBy("created_at", "ASC")
            ->get();

        // get data log
        $uuid_profile = $auth->uuid_profile;
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
            "auth" => $auth,
            "profile" => $profile,
            "alamat_perusahaan" => $alamatPerusahaan,
            "logs_login" => $logs_login,
            "logs_aktifitas" => $logs_aktifitas,
        ];

        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }

    // update
    public function update(Request $request)
    {
        $path_form = $request->path_form;

        if ($path_form == "profile") {
            return $this->updateProfile($request);
        } elseif ($path_form == "alamat") {
            return $this->updateAlamat($request);
        } elseif ($path_form == "keamanan") {
            return $this->updateKeamanan($request);
        } else {
            return \abort(404);
        }
    }
    // update profile
    private function updateProfile($request)
    {
        // auth
        $auth = auth()->user();
        $profile = $auth->RelPerusahaan;
        $uuid_profile = $auth->uuid_profile;
        $jp = $profile->jenis_perusahaan;

        // validate
        $validator = Validator::make($request->all(), [
            "nama_perusahaan" => "required|string|max:100",
            "nama_pic" => "required|string|max:100",
            "npwp" => "required|string|max:100",
            "email" => "required|string|max:100",
            "no_telp_1" => "required|string|max:15",
            "no_telp_2" => "sometimes|nullable|string|max:15",
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
        $npwp = $request->npwp;
        $email = $request->email;
        // cek npwp
        if ($npwp != $profile->npwp) {
            $cekNpwp = Perusahaan::whereNpwp($npwp)->first();
            if ($cekNpwp !== null) {
                // ada perusahaan
                $response = [
                    "status" => false,
                    "message" => "NPWP Sudah Digunakan Oleh Perusahaan Lain, Mohon Cek Kembali NPWP Anda!",
                    "request" => $request->all(),
                ];
                return response()->json($response, 422);
            }
        }
        // cek email
        if ($email != $profile->email) {
            $cekEmail = Perusahaan::whereEmail($email)->first();
            if ($cekEmail !== null) {
                // ada perusahaan
                $response = [
                    "status" => false,
                    "message" => "Email Sudah Digunakan Oleh Perusahaan Lain, Mohon Cek Kembali Email Anda!",
                    "request" => $request->all(),
                ];
                return response()->json($response, 422);
            }
        }

        // value perusahaan
        $value_1 = [
            "nama_perusahaan" => $request->nama_perusahaan,
            "nama_pic" => $request->nama_pic,
            "npwp" => $npwp,
            "email" => Str::lower($email),
            "no_telp_1" => $request->no_telp_1,
            "no_telp_2" => $request->no_telp_2,
        ];

        // foto
        $path = "perusahaan/" . $uuid_profile;
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

        // file_npwp
        if ($request->hasFile('file_npwp')) {
            $file_npwp = CID::UpImgPdf($request, "file_npwp", $path);
            if ($file_npwp == "0") {
                $response = [
                    "status" => false,
                    "message" => "Gagal Menyimpan Data, File NPWP Tidak Sesuai Format!",
                    "request" => $request->all(),
                ];
                return response()->json($response, 422);
            }
            $value_1['file_npwp'] = $file_npwp['url'];
        }

        // save
        $save_1 = Perusahaan::whereUuid($uuid_profile)->update($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("perusahaan"),
                "uuid" => array($uuid_profile),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Penjadwalan dan Penugasan Apps",
                "subjek" => "Berhasil Mengubah Profile " . $jp . " dengan UUID= " . $uuid_profile,
                "aktifitas" => $aktifitas,
                "role" => "Perusahaan",
                "device" => "mobile",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            $response = [
                "status" => true,
                "message" => 'Berhasil Mengubah Profile ' . $jp,
            ];
            return response()->json($response, 201);
        } else {
            $response = [
                "status" => false,
                "message" => 'Gagal Mengubah Profile ' . $jp,
                "request" => $request->all(),
            ];
            return response()->json($response, 422);
        }
    }
    // update alamat
    private function updateAlamat($request)
    {
        // auth
        $auth = auth()->user();
        $profile = $auth->RelPerusahaan;
        $uuid_profile = $auth->uuid_profile;

        // validate
        $validator = Validator::make($request->all(), [
            "district_id" => "required|string|max:10",
            "village_id" => "required|string|max:10",
            "alamat" => "required|string|max:300",
            "rt" => "required|string|max:3",
            "rw" => "required|string|max:3",
            "kode_pos" => "required|string|max:5",
            "lat" => "sometimes|nullable|string|max:100",
            "long" => "sometimes|nullable|string|max:100",
            "google_maps" => "sometimes|nullable|string|max:300",
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

        // cek update or create
        if (isset($request->uuid_form)) {
            // update
            $uuid = $request->uuid_form;
            $data = AlamatPerusahaan::findOrFail($uuid);
            $value_1 = [
                "district_id" => $request->district_id,
                "village_id" => $request->village_id,
                "alamat" => $request->alamat,
                "rt" => $request->rt,
                "rw" => $request->rw,
                "kode_pos" => $request->kode_pos,
                "lat" => $request->lat,
                "long" => $request->long,
                "google_maps" => $request->google_maps,
                "uuid_updated" => $uuid_profile,
            ];

            // save
            $save_1 = $data->update($value_1);
            if ($save_1) {
                // create log
                $aktifitas = [
                    "tabel" => array("alamat_perusahaan"),
                    "uuid" => array($uuid),
                    "value" => array($value_1),
                ];
                $log = [
                    "apps" => "Penjadwalan dan Penugasan Apps",
                    "subjek" => "Berhasil Mengubah Alamat Perusahaan/Usaha dengan UUID= " . $uuid,
                    "aktifitas" => $aktifitas,
                    "role" => "Perusahaan",
                    "device" => "mobile",
                ];
                CID::addToLogAktifitas($request, $log);
                // alert success
                $response = [
                    "status" => true,
                    "message" => 'Berhasil Mengubah Alamat Perusahaan/Usaha.',
                ];
                return response()->json($response, 200);
            } else {
                $response = [
                    "status" => false,
                    "message" => 'Gagal Mengubah Alamat Perusahaan/Usaha.',
                    "request" => $request->all(),
                ];
                return response()->json($response, 422);
            }
        } else {
            // create
            // cek alamat
            $cekAlamat = AlamatPerusahaan::whereUuidPerusahaan($uuid_profile)->first();
            if ($cekAlamat === null) {
                $default = "1";
            } else {
                $default = "0";
            }

            // value perusahaan
            $uuid = Str::uuid();
            $value_1 = [
                "uuid" => $uuid,
                "uuid_perusahaan" => $uuid_profile,
                "province_id" => "36",
                "regency_id" => "3603",
                "district_id" => $request->district_id,
                "village_id" => $request->village_id,
                "alamat" => $request->alamat,
                "rt" => $request->rt,
                "rw" => $request->rw,
                "kode_pos" => $request->kode_pos,
                "lat" => $request->lat,
                "long" => $request->long,
                "google_maps" => $request->google_maps,
                "default" => $default,
                "uuid_created" => $uuid_profile,
            ];

            // save
            $save_1 = AlamatPerusahaan::create($value_1);
            if ($save_1) {
                // create log
                $aktifitas = [
                    "tabel" => array("alamat_perusahaan"),
                    "uuid" => array($uuid),
                    "value" => array($value_1),
                ];
                $log = [
                    "apps" => "Penjadwalan dan Penugasan Apps",
                    "subjek" => "Berhasil Menambahkan Alamat Perusahaan/Usaha dengan UUID= " . $uuid,
                    "aktifitas" => $aktifitas,
                    "role" => "Perusahaan",
                    "device" => "mobile",
                ];
                CID::addToLogAktifitas($request, $log);
                // alert success
                $response = [
                    "status" => true,
                    "message" => 'Berhasil Menambahkan Alamat Perusahaan/Usaha.',
                ];
                return response()->json($response, 200);
            } else {
                $response = [
                    "status" => false,
                    "message" => 'Gagal Menambahkan Alamat Perusahaan/Usaha.',
                    "request" => $request->all(),
                ];
                return response()->json($response, 422);
            }
        }
    }
    // update alamat
    private function updateKeamanan($request)
    {
        // auth
        $auth = auth()->user();
        $username = $auth->username;
        $profile = $auth->RelPerusahaan;
        $uuid_profile = $auth->uuid_profile;

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
        if (!Hash::check($old_password, $auth->password)) {
            // password lama salah
            $response = [
                "status" => false,
                "message" => 'Password Lama Anda Salah!',
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
        $value_1 = [
            "username" => $username,
            "password" => \bcrypt($new_password),
            "uuid_updated" => $uuid_profile,
        ];

        // save
        $save_1 = User::whereUuidProfile($uuid_profile)->update($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("users"),
                "uuid" => array($auth->uuid),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Penjadwalan dan Penugasan Apps",
                "subjek" => "Berhasil Mengubah Akun Login dengan UUID= " . $auth->uuid,
                "aktifitas" => $aktifitas,
                "role" => "Perusahaan",
                "device" => "mobile",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            $response = [
                "status" => true,
                "message" => 'Berhasil Mengubah Keamanan Akun.',
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                "status" => false,
                "message" => 'Gagal Mengubah Keamanan Akun.',
                "request" => $request->all(),
            ];
            return response()->json($response, 422);
        }
    }

    // showAlamat
    public function showAlamat($uuid_enc)
    {
        $uuid = $uuid_enc;
        $data = AlamatPerusahaan::with('RelPerusahaan')
            ->with("Provinsi")
            ->with("Kabupaten")
            ->with("Kecamatan")
            ->with("Desa")
            ->find($uuid);
        if ($data === null) {
            $response = [
                "status" => false,
                "message" => "Data Tidak Ditemukan!",
            ];
            return response()->json($response, 404);
        }

        // data ditemukan
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // uuid
        $uuid = $request->uuid;

        // data
        $data = AlamatPerusahaan::findOrFail($uuid);

        // save
        $save_1 = $data->delete();
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("alamat_perusahaan"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Penjadwalan dan Penugasan Apps",
                "subjek" => "Berhasil Menghapus Alamat Perusahaan/Usaha dengan UUID= " . $uuid,
                "aktifitas" => $aktifitas,
                "role" => "Perusahaan",
                "device" => "mobile",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            $msg = "Data Berhasil Dihapus!";
            $response = [
                "status" => true,
                "message" => $msg,
            ];
            return response()->json($response, 200);
        } else {
            // success
            $msg = "Data Gagal Dihapus!";
            $response = [
                "status" => false,
                "message" => $msg,
            ];
            return response()->json($response, 422);
        }
    }
}
