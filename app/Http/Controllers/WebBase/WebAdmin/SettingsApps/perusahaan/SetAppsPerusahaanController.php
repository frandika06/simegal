<?php

namespace App\Http\Controllers\WebBase\WebAdmin\SettingsApps\perusahaan;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\AlamatPerusahaan;
use App\Models\Perusahaan;
use App\Models\SysLogAktifitas;
use App\Models\SysLogin;
use App\Models\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SetAppsPerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $enc_tags)
    {
        // tags
        $tags = CID::decode($enc_tags);

        return view('pages.admin.settings_apps.perusahaan.index', compact(
            'enc_tags',
            'tags',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // auth
        $auth = Auth::user();

        // validate
        $request->validate([
            "jenis_perusahaan" => "required|string|max:100",
            "nama_perusahaan" => "required|string|max:100",
            "nama_pic" => "required|string|max:100",
            "npwp" => "required|string|max:100",
            "email" => "required|string|unique:perusahaan,email|max:100",
            "no_telp_1" => "required|string|max:100",
            "username" => "required|string|unique:users,username|max:100",
            "password" => "required|string|max:100",
        ]);

        //Submit Register
        $npwp = $request->npwp;
        // cek perusahaan
        $cekPerusahaan = Perusahaan::whereNpwp($npwp)->first();
        if ($cekPerusahaan !== null) {
            // ada perusahaan
            alert()->error('Gagal Register!', 'Perusahaan Sudah Terdaftar, Silahkan Login/Reset Password!');
            return back()->withInput($request->all());
        }

        // value perusahaan
        $uuid_profile = Str::uuid();
        $jp = $request->jenis_perusahaan;
        $kode = CID::genKodePerusahaan($jp);
        $value_1 = [
            "uuid" => $uuid_profile,
            "kode_perusahaan" => $kode,
            "jenis_perusahaan" => $jp,
            "nama_perusahaan" => $request->nama_perusahaan,
            "nama_pic" => $request->nama_pic,
            "npwp" => $request->npwp,
            "email" => Str::lower($request->email),
            "no_telp_1" => $request->no_telp_1,
            "uuid_created" => $auth->uuid_profile,
        ];

        // foto
        $path = "perusahaan/" . $uuid_profile;
        if ($request->hasFile('foto')) {
            $foto = CID::UpImg($request, "foto", $path);
            if ($foto == "0") {
                alert()->error('Error!', 'Gagal Menyimpan Data, Foto Tidak Sesuai Format!');
                return back();
            }
            $value_1['foto'] = $foto;
        }

        // file_npwp
        if ($request->hasFile('file_npwp')) {
            $file_npwp = CID::UpImgPdf($request, "file_npwp", $path);
            if ($file_npwp == "0") {
                alert()->error('Error!', 'Gagal Menyimpan Data, File NPWP Tidak Sesuai Format!');
                return back();
            }
            $value_1['file_npwp'] = $file_npwp['url'];
        }

        // value user
        $uuid = Str::uuid();
        $value_2 = [
            "uuid" => $uuid,
            "uuid_profile" => $uuid_profile,
            "username" => $request->username,
            "password" => bcrypt($request->password),
            "role" => $auth->role,
            "uuid_created" => $auth->uuid_profile,
        ];

        // save
        $save_1 = Perusahaan::create($value_1);
        $save_2 = User::create($value_2);
        if ($save_1 && $save_2) {
            // create log
            $aktifitas = [
                "tabel" => array("perusahaan", "users"),
                "uuid" => array($uuid_profile, $uuid),
                "value" => array($value_1, $value_2),
            ];
            $log = [
                "uuid_profile" => $uuid_profile,
                "apps" => "Settings Apps",
                "subjek" => "Berhasil Menambahkan " . $jp . " : " . $request->nama_perusahaan . " - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "1",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Success', "Berhasil Menambahkan " . $jp . ", Silahkan Lengkapi Data!");
            return redirect()->route('set.apps.perusahaan.edit', [CID::encode('Baru Daftar'), CID::encode($uuid_profile)]);
        } else {
            alert()->error('Error', "Gagal Menambahkan " . $jp);
            return back()->withInput($request->all());
        }
    }

    // status aktifkan perusahaan
    public function statusAktifkan(Request $request, $enc_tags)
    {
        // auth
        $auth = Auth::user();

        // uuid
        $uuid = CID::decode($request->uuid);

        // data
        $data = Perusahaan::findOrFail($uuid);

        // value_1
        $value_1 = [
            "verifikasi" => "1",
            "status" => "1",
            "uuid_updated" => $auth->uuid_profile,
        ];
        // value_2
        $value_2 = [
            "status" => "1",
            "uuid_updated" => $auth->uuid_profile,
        ];

        // save
        $save_1 = $data->update($value_1);
        $save_2 = User::whereUuidProfile($uuid)->update($value_2);
        if ($save_1 && $save_2) {
            // create log
            $aktifitas = [
                "tabel" => array("perusahaan"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Settings Apps",
                "subjek" => "Berhasil Mengaktifkan Perusahaan: " . $data->nama_perusahaan . " (" . $data->kode_perusahaan . ") - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "1",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            $msg = "Perusahaan Berhasil Diaktifkan!";
            $response = [
                "status" => true,
                "message" => $msg,
            ];
            return response()->json($response, 200);
        } else {
            // success
            $msg = "Perusahaan Gagal Diaktifkan!";
            $response = [
                "status" => false,
                "message" => $msg,
            ];
            return response()->json($response, 422);
        }
    }
    // status ditangguhkan perusahaan
    public function statusTangguhkan(Request $request, $enc_tags)
    {
        // auth
        $auth = Auth::user();

        // uuid
        $uuid = CID::decode($request->uuid);

        // data
        $data = Perusahaan::findOrFail($uuid);

        // value_1
        $value_1 = [
            "verifikasi" => "1",
            "status" => "0",
            "uuid_updated" => $auth->uuid_profile,
        ];
        // value_2
        $value_2 = [
            "status" => "0",
            "uuid_updated" => $auth->uuid_profile,
        ];

        // save
        $save_1 = $data->update($value_1);
        $save_2 = User::whereUuidProfile($uuid)->update($value_2);
        if ($save_1 && $save_2) {
            // create log
            $aktifitas = [
                "tabel" => array("perusahaan"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Settings Apps",
                "subjek" => "Berhasil Menagguhkan Perusahaan: " . $data->nama_perusahaan . " (" . $data->kode_perusahaan . ") - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "1",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            $msg = "Perusahaan Berhasil Ditangguhkan!";
            $response = [
                "status" => true,
                "message" => $msg,
            ];
            return response()->json($response, 200);
        } else {
            // success
            $msg = "Perusahaan Gagal Ditangguhkan!";
            $response = [
                "status" => false,
                "message" => $msg,
            ];
            return response()->json($response, 422);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $enc_tags, $enc_uuid)
    {
        // uuid
        $uuid = CID::decode($enc_uuid);
        // profile
        $profile = Perusahaan::findOrFail($uuid);
        // tags
        $tags = CID::decode($enc_tags);

        // get kecamatan
        $idKab = "3603"; //Kab. Tangerang
        $urlDataKec = route('wiladm.data.kec', [$idKab]);
        $response = Http::get($urlDataKec);
        $dataKec = $response->object()->data;

        // get data alamat
        $alamatPerusahaan = AlamatPerusahaan::whereUuidPerusahaan($profile->uuid)
            ->orderBy("created_at", "ASC")
            ->get();

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
        return view('pages.admin.settings_apps.perusahaan.edit_profile.profile', compact(
            'enc_tags',
            'enc_uuid',
            'tags',
            'profile',
            'dataKec',
            'alamatPerusahaan',
            'logs_login',
            'logs_aktifitas',
        ));
    }

    // update
    public function update(Request $request, $enc_tags, $enc_uuid)
    {
        // decode
        $tags = CID::decode($enc_tags);
        $uuid = CID::decode($enc_uuid);
        $path_form = $request->path_form;
        if ($path_form == "profile") {
            return $this->updateProfile($request, $uuid);
        } elseif ($path_form == "alamat") {
            return $this->updateAlamat($request, $uuid);
        } elseif ($path_form == "keamanan") {
            return $this->updateKeamanan($request, $uuid);
        } else {
            return \abort(404);
        }
    }
    // update profile
    private function updateProfile($request, $uuid)
    {
        // auth
        $auth = Auth::user();
        $profile = Perusahaan::findOrFail($uuid);
        $uuid_profile = $auth->uuid_profile;
        $jp = $profile->jenis_perusahaan;

        // validate
        $request->validate([
            "nama_perusahaan" => "required|string|max:100",
            "nama_pic" => "required|string|max:100",
            "npwp" => "required|string|max:100",
            "email" => "required|string|max:100",
            "no_telp_1" => "required|string|max:15",
            "no_telp_2" => "sometimes|nullable|string|max:15",
        ]);

        //Submit Register
        $npwp = $request->npwp;
        $email = $request->email;
        // cek npwp
        if ($npwp != $profile->npwp) {
            $cekNpwp = Perusahaan::whereNpwp($npwp)->first();
            if ($cekNpwp !== null) {
                // ada perusahaan
                alert()->error('Gagal Simpan!', 'NPWP Sudah Digunakan Oleh Perusahaan Lain, Mohon Cek Kembali NPWP Perusahaan!');
                return back()->withInput($request->all());
            }
        }
        // cek email
        if ($email != $profile->email) {
            $cekEmail = Perusahaan::whereEmail($email)->first();
            if ($cekEmail !== null) {
                // ada perusahaan
                alert()->error('Gagal Simpan!', 'Email Sudah Digunakan Oleh Perusahaan Lain, Mohon Cek Kembali Email Perusahaan!');
                return back()->withInput($request->all());
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
            "uuid_updated" => $uuid_profile,
        ];

        // foto
        $path = "perusahaan/" . $uuid;
        if ($request->hasFile('foto')) {
            $foto = CID::UpImg($request, "foto", $path);
            if ($foto == "0") {
                alert()->error('Error!', 'Gagal Menyimpan Data, Foto Tidak Sesuai Format!');
                return back();
            }
            $value_1['foto'] = $foto;
        }

        // file_npwp
        if ($request->hasFile('file_npwp')) {
            $file_npwp = CID::UpImgPdf($request, "file_npwp", $path);
            if ($file_npwp == "0") {
                alert()->error('Error!', 'Gagal Menyimpan Data, File NPWP Tidak Sesuai Format!');
                return back();
            }
            $value_1['file_npwp'] = $file_npwp['url'];
        }

        // save
        $save_1 = Perusahaan::whereUuid($uuid)->update($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("perusahaan"),
                "uuid" => array($uuid),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Settings Apps",
                "subjek" => "Berhasil Mengubah Profile " . $jp . " : " . $request->nama_perusahaan . " - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "1",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Berhasil!', 'Berhasil Mengubah Profile ' . $jp . " : " . $request->nama_perusahaan);
            return back();
        } else {
            alert()->error('Gagal!', 'Gagal Mengubah Profile ' . $jp . " : " . $request->nama_perusahaan);
            return back()->withInput($request->all());
        }
    }
    // update alamat
    private function updateKeamanan($request, $uuid_perusahaan)
    {
        // auth
        $auth = Auth::user();
        $profile = Perusahaan::findOrFail($uuid_perusahaan);
        $username = $profile->RelUser->username;
        $uuid_profile = $auth->uuid_profile;

        // validate
        $request->validate([
            "username" => "required|string|max:100",
            "new_password" => "required|string|max:100",
        ]);

        // value_1
        $new_username = $request->username;
        $new_password = $request->new_password;

        // cek username
        if ($new_username != $username) {
            // validate
            $request->validate([
                "username" => "required|unique:users,username|max:100",
            ]);
            $username = $new_username;
        }
        $value_1 = [
            "username" => $username,
            "password" => \bcrypt($new_password),
            "uuid_updated" => $uuid_profile,
        ];

        // save
        $save_1 = User::whereUuidProfile($uuid_perusahaan)->update($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("users"),
                "uuid" => array($profile->RelUser->uuid),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Settings Apps",
                "subjek" => "Berhasil Mengubah Akun Login Perusahaan " . $profile->nama_perusahaan . " - " . $profile->uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "1",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Berhasil!', 'Berhasil Mengubah Keamanan Akun.');
            return back();
        } else {
            alert()->error('Gagal!', 'Gagal Mengubah Keamanan Akun.');
            return back()->withInput($request->all());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(Request $request, $enc_tags, $enc_uuid)
    {
        // uuid
        $uuid = CID::decode($enc_uuid);
        // profile
        $profile = Perusahaan::findOrFail($uuid);
        // tags
        $tags = CID::decode($enc_tags);

        // get kecamatan
        $idKab = "3603"; //Kab. Tangerang
        $urlDataKec = route('wiladm.data.kec', [$idKab]);
        $response = Http::get($urlDataKec);
        $dataKec = $response->object()->data;

        // get data alamat
        $alamatPerusahaan = AlamatPerusahaan::whereUuidPerusahaan($profile->uuid)
            ->orderBy("created_at", "ASC")
            ->get();

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
        return view('pages.admin.settings_apps.perusahaan.view_profile.profile', compact(
            'enc_tags',
            'enc_uuid',
            'tags',
            'profile',
            'dataKec',
            'alamatPerusahaan',
            'logs_login',
            'logs_aktifitas',
        ));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $enc_tags)
    {
        // auth
        $auth = Auth::user();

        // uuid
        $uuid = CID::decode($request->uuid);

        // data
        $data = Perusahaan::findOrFail($uuid);

        // save
        $save_1 = $data->delete();
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("perusahaan"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Settings Apps",
                "subjek" => "Berhasil Menghapus Perusahaan: " . $data->nama_perusahaan . " (" . $data->kode_perusahaan . ") - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "1",
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

    /**
     * BARISAN ALAMAT PERUSAHAAN
     */
    // update alamat
    private function updateAlamat($request, $uuid_perusahaan)
    {
        // auth
        $auth = Auth::user();
        $profile = Perusahaan::findOrFail($uuid_perusahaan);
        $uuid_profile = $auth->uuid_profile;

        // validate
        $request->validate([
            "label_alamat" => "required|string|max:100",
            "district_id" => "required|string|max:10",
            "village_id" => "required|string|max:10",
            "alamat" => "required|string|max:300",
            "rt" => "sometimes|nullable|string|max:3",
            "rw" => "sometimes|nullable|string|max:3",
            "kode_pos" => "sometimes|nullable|string|max:5",
            "lat" => "sometimes|nullable|string|max:100",
            "long" => "sometimes|nullable|string|max:100",
            "google_maps" => "sometimes|nullable|string|max:300",
        ]);

        // cek update or create
        if (isset($request->uuid_form)) {
            // update
            $uuid = CID::decode($request->uuid_form);
            $data = AlamatPerusahaan::findOrFail($uuid);
            $value_1 = [
                "label_alamat" => $request->label_alamat,
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
                    "apps" => "Settings Apps",
                    "subjek" => "Berhasil Mengubah Alamat Perusahaan/Usaha : " . $profile->nama_perusahaan . " - " . $uuid,
                    "aktifitas" => $aktifitas,
                    "device" => "web",
                    "dashboard" => "1",
                ];
                CID::addToLogAktifitas($request, $log);
                // alert success
                alert()->success('Berhasil!', 'Berhasil Mengubah Alamat Perusahaan/Usaha.');
                return back();
            } else {
                alert()->error('Gagal!', 'Gagal Mengubah Alamat Perusahaan/Usaha.');
                return back()->withInput($request->all());
            }
        } else {
            // create
            // cek alamat
            $cekAlamat = AlamatPerusahaan::whereUuidPerusahaan($uuid_perusahaan)->first();
            if ($cekAlamat === null) {
                $default = "1";
            } else {
                $default = "0";
            }

            // value perusahaan
            $uuid = Str::uuid();
            $value_1 = [
                "uuid" => $uuid,
                "uuid_perusahaan" => $uuid_perusahaan,
                "province_id" => "36",
                "regency_id" => "3603",
                "label_alamat" => $request->label_alamat,
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
                    "apps" => "Settings Apps",
                    "subjek" => "Berhasil Menambahkan Alamat Perusahaan/Usaha : " . $profile->nama_perusahaan . " - " . $uuid,
                    "aktifitas" => $aktifitas,
                    "device" => "web",
                    "dashboard" => "1",
                ];
                CID::addToLogAktifitas($request, $log);
                // alert success
                alert()->success('Berhasil!', 'Berhasil Menambahkan Alamat Perusahaan/Usaha.');
                return back();
            } else {
                alert()->error('Gagal!', 'Gagal Menambahkan Alamat Perusahaan/Usaha.');
                return back()->withInput($request->all());
            }
        }
    }
    // defaultAlamat
    public function defaultAlamat(Request $request, $enc_tags)
    {
        // auth
        $auth = Auth::user();
        $uuid_profile = $auth->uuid_profile;

        // uuid
        $uuid = CID::decode($request->uuid);

        // data
        $data = AlamatPerusahaan::findOrFail($uuid);
        $uuid_perusahaan = $data->uuid_perusahaan;

        // value
        $value_1 = [
            "default" => "1",
            "uuid_updated" => $uuid_profile,
        ];

        // update default
        $save_1 = AlamatPerusahaan::where("uuid_perusahaan", $uuid_perusahaan)->update(["default" => "0"]);
        $save_2 = AlamatPerusahaan::where("uuid", $uuid)->update($value_1);

        if ($save_1 && $save_2) {
            // create log
            $aktifitas = [
                "tabel" => array("alamat_perusahaan"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Settings Apps",
                "subjek" => "Berhasil Mengubah Alamat Default Perusahaan/Usaha - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "1",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            $msg = "Berhasil Mengubah Alamat Default Perusahaan/Usaha!";
            $response = [
                "status" => true,
                "message" => $msg,
            ];
            return response()->json($response, 200);
        } else {
            // success
            $msg = "Gagal Mengubah Alamat Default Perusahaan/Usaha!";
            $response = [
                "status" => false,
                "message" => $msg,
            ];
            return response()->json($response, 422);
        }
    }
    // showAlamat
    public function showAlamat($enc_tags, $enc_uuid)
    {
        $uuid = CID::decode($enc_uuid);
        $data = AlamatPerusahaan::find($uuid);
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
    // destroyAlamat
    public function destroyAlamat(Request $request, $enc_tags)
    {
        // auth
        $auth = Auth::user();

        // uuid
        $uuid = CID::decode($request->uuid);

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
                "apps" => "Settings Apps",
                "subjek" => "Berhasil Menghapus Alamat Perusahaan/Usaha - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "1",
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

    /**
     * Data untuk Datatables
     */
    public function data(Request $request, $enc_tags)
    {
        // tags
        $tags = CID::decode($enc_tags);
        if ($tags == "Baru Daftar") {
            $data = Perusahaan::where("file_npwp", "=", null)
                ->where("verifikasi", "=", "0")
                ->orderBy("created_at", "DESC")
                ->get();
        } elseif ($tags == "Perlu Verifikasi") {
            $data = Perusahaan::where("file_npwp", "!=", null)
                ->where("verifikasi", "=", "0")
                ->orderBy("created_at", "DESC")
                ->get();
        } elseif ($tags == "Aktif") {
            $data = Perusahaan::where("file_npwp", "!=", null)
                ->where("verifikasi", "=", "1")
                ->where("status", "=", "1")
                ->orderBy("created_at", "DESC")
                ->get();
        } elseif ($tags == "Ditangguhkan") {
            $data = Perusahaan::where("file_npwp", "!=", null)
                ->where("verifikasi", "=", "1")
                ->where("status", "=", "0")
                ->orderBy("created_at", "DESC")
                ->get();
        }

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->setRowId('uuid')
                ->addColumn('kontak', function ($data) {
                    $kontak = '<p class="p-0 m-0"><strong>Nama PIC:</strong> ' . $data->nama_pic . '</p>';
                    $kontak .= '<p class="p-0 m-0"><strong>No. Telp 1:</strong> ' . $data->no_telp_1 . '</p>';
                    $kontak .= '<p class="p-0 m-0"><strong>No. Telp 2:</strong> ' . $data->no_telp_2 . '</p>';
                    $kontak .= '<p class="p-0 m-0"><strong>Email:</strong> ' . $data->email . '</p>';
                    return $kontak;
                })
                ->addColumn('aksi', function ($data) use ($enc_tags) {
                    $enc_uuid = CID::encode($data->uuid);
                    $subRoleVerifikator = CID::subRoleVerifikator();
                    $edit = route('set.apps.perusahaan.edit', [$enc_tags, $enc_uuid]);
                    $show = route('set.apps.perusahaan.show', [$enc_tags, $enc_uuid]);

                    if ($subRoleVerifikator == true) {
                        // tags
                        $tags = CID::decode($enc_tags);
                        if ($tags == "Baru Daftar") {
                            $aksi = '<div class="dropdown">
                                <button class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Aksi
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="' . $edit . '"><i class="fa-solid fa-edit me-2"></i> Edit</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);" data-delete="' . $enc_uuid . '"><i class="fa-solid fa-trash me-2"></i> Hapus</a></li>
                                </ul>
                                </div>';
                        } elseif ($tags == "Perlu Verifikasi") {
                            $aksi = '<div class="dropdown">
                                <button class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Aksi
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="' . $edit . '"><i class="fa-solid fa-edit me-2"></i> Edit</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);" data-status-aktifkan="' . $enc_uuid . '"><i class="fa-solid fa-check-double me-2"></i> Aktifkan</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);" data-delete="' . $enc_uuid . '"><i class="fa-solid fa-trash me-2"></i> Hapus</a></li>
                                </ul>
                                </div>';
                        } elseif ($tags == "Aktif") {
                            $aksi = '<div class="dropdown">
                                <button class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Aksi
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="' . $edit . '"><i class="fa-solid fa-edit me-2"></i> Edit</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);" data-status-tangguhkan="' . $enc_uuid . '"><i class="fa-solid fa-lock me-2"></i> Tangguhkan</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);" data-delete="' . $enc_uuid . '"><i class="fa-solid fa-trash me-2"></i> Hapus</a></li>
                                </ul>
                                </div>';
                        } elseif ($tags == "Ditangguhkan") {
                            $aksi = '<div class="dropdown">
                                <button class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Aksi
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="' . $edit . '"><i class="fa-solid fa-edit me-2"></i> Edit</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);" data-status-aktifkan="' . $enc_uuid . '"><i class="fa-solid fa-check-double me-2"></i> Aktifkan</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);" data-delete="' . $enc_uuid . '"><i class="fa-solid fa-trash me-2"></i> Hapus</a></li>
                                </ul>
                                </div>';
                        }
                    } else {
                        $aksi = '<div class="dropdown">
                            <button class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="' . $show . '"><i class="fa-solid fa-info-circle me-2"></i> Detail</a></li>
                            </ul>
                            </div>';
                    }
                    return $aksi;
                })
                ->escapeColumns([''])
                ->make(true);
        }
    }
}
