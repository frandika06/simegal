<?php

namespace App\Http\Controllers\WebBase\WebAdmin\SettingsApps\pegawai;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\SysLogAktifitas;
use App\Models\SysLogin;
use App\Models\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SetAppsPegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('pages.admin.settings_apps.pegawai.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // auth
        $auth = Auth::user();
        $uuid_profile = $auth->uuid_profile;

        // validate
        $request->validate([
            "nama_lengkap" => "required|string|max:100",
            "nip" => "required|string|max:100",
            "pangkat_golongan" => "required|string|max:100",
            "jabatan" => "required|string|max:100",
            "jenis_kelamin" => "required|string|max:100",
            "email" => "required|string|unique:pegawai,email|max:100",
            "no_telp" => "required|string|max:15",
            "username" => "required|string|unique:users,username|max:100",
            "password" => "required|string|max:100",
            "sub_role" => "required|array|max:100",
        ]);

        // value Pegawai
        $uuid_pegawai = Str::uuid();
        $nip = $request->nip;
        if ($nip == "0") {
            $status_pegawai = "Non ASN";
        } else {
            $status_pegawai = "ASN";
        }
        $value_1 = [
            "uuid" => $uuid_pegawai,
            "nama_lengkap" => $request->nama_lengkap,
            "nip" => $nip,
            "pangkat_golongan" => $request->pangkat_golongan,
            "jabatan" => $request->jabatan,
            "jenis_kelamin" => $request->jenis_kelamin,
            "email" => Str::lower($request->email),
            "no_telp" => $request->no_telp,
            "status_pegawai" => $status_pegawai,
            "uuid_created" => $uuid_profile,
        ];

        // value user
        $uuid_user = Str::uuid();
        $value_2 = [
            "uuid" => $uuid_user,
            "uuid_profile" => $uuid_pegawai,
            "username" => $request->username,
            "password" => bcrypt($request->password),
            "role" => "Pegawai",
            "sub_role" => implode(",", $request->sub_role),
        ];

        // cek sub_role_ketua_tim
        if (in_array("Ketua Tim", $request->sub_role)) {
            // validate
            $request->validate([
                "sub_role_ketua_tim" => "required|string|max:100",
            ]);
            $value_2['sub_sub_role'] = $request->sub_role_ketua_tim;
        } else {
            $value_2['sub_sub_role'] = null;
        }

        // foto
        $path = "pegawai/" . $uuid_pegawai;
        if ($request->hasFile('foto')) {
            $foto = CID::UpImg($request, "foto", $path);
            if ($foto == "0") {
                alert()->error('Error!', 'Gagal Menyimpan Data, Foto Tidak Sesuai Format!');
                return back();
            }
            $value_1['foto'] = $foto;
        }

        // save
        $save_1 = Pegawai::create($value_1);
        $save_2 = User::create($value_2);
        if ($save_1 && $save_2) {
            // create log
            $aktifitas = [
                "tabel" => array("pegawai", "users"),
                "uuid" => array($uuid_pegawai, $uuid_user),
                "value" => array($value_1, $value_2),
            ];
            $log = [
                "apps" => "Settings Apps",
                "subjek" => "Menambahkan Akun Pegawai: " . $request->nama_lengkap . " - " . $uuid_pegawai,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "1",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Berhasil!', "Berhasil Menambahkan Pegawai: " . $request->nama_lengkap);
            return back();
        } else {
            alert()->error('Gagal!', "Gagal Menambahkan Pegawai: " . $request->nama_lengkap);
            return back()->withInput($request->all());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $enc_uuid)
    {
        // uuid
        $uuid = CID::decode($enc_uuid);

        // data
        $data = Pegawai::findOrFail($uuid);

        // get data log
        $uuid_profile = $data->uuid;
        $logs_login = SysLogin::whereUuidProfile($uuid_profile)
            ->whereMonth("created_at", date('m'))
            ->orderBy("created_at", "DESC")
            ->get();
        $logs_aktifitas = SysLogAktifitas::whereUuidProfile($uuid_profile)
            ->whereMonth("created_at", date('m'))
            ->orderBy("created_at", "DESC")
            ->get();
        return view('pages.admin.settings_apps.pegawai.edit_profile.profile', compact(
            'enc_uuid',
            'data',
            'logs_login',
            'logs_aktifitas',
        ));
    }

    // update
    public function update(Request $request, $enc_uuid)
    {
        // decode
        $uuid = CID::decode($enc_uuid);
        $path_form = $request->path_form;
        if ($path_form == "profile") {
            return $this->updateProfile($request, $uuid);
        } elseif ($path_form == "keamanan") {
            return $this->updateKeamanan($request, $uuid);
        } elseif ($path_form == "hak_akses") {
            return $this->updateHakAkses($request, $uuid);
        } else {
            return abort(404);
        }
    }
    // update profile
    private function updateProfile($request, $uuid)
    {
        // auth
        $auth = Auth::user();
        $uuid_profile = $auth->uuid_profile;
        $data = Pegawai::findOrFail($uuid);

        // validate
        $request->validate([
            "nama_lengkap" => "required|string|max:100",
            "nip" => "required|string|max:100",
            "pangkat_golongan" => "required|string|max:100",
            "jabatan" => "required|string|max:100",
            "jenis_kelamin" => "required|string|max:100",
            "email" => "required|string|max:100",
            "no_telp" => "required|string|max:15",
        ]);

        //Submit Register
        $email = $request->email;
        // cek email
        if ($email != $data->email) {
            $cekEmail = Pegawai::whereEmail($email)->first();
            if ($cekEmail !== null) {
                // ada Pegawai
                alert()->error('Gagal Simpan!', 'Email Sudah Digunakan Oleh Pegawai Lain, Mohon Cek Kembali Alamat Email!');
                return back()->withInput($request->all());
            }
        }

        // value Pegawai
        $nip = $request->nip;
        if ($nip == "0") {
            $status_pegawai = "Non ASN";
        } else {
            $status_pegawai = "ASN";
        }
        $value_1 = [
            "nama_lengkap" => $request->nama_lengkap,
            "nip" => $nip,
            "pangkat_golongan" => $request->pangkat_golongan,
            "jabatan" => $request->jabatan,
            "jenis_kelamin" => $request->jenis_kelamin,
            "email" => Str::lower($email),
            "no_telp" => $request->no_telp,
            "status_pegawai" => $status_pegawai,
            "uuid_updated" => $uuid_profile,
        ];

        // foto
        $path = "pegawai/" . $uuid;
        if ($request->hasFile('foto')) {
            $foto = CID::UpImg($request, "foto", $path);
            if ($foto == "0") {
                alert()->error('Error!', 'Gagal Menyimpan Data, Foto Tidak Sesuai Format!');
                return back();
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
                "device" => "web",
                "dashboard" => "1",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Berhasil!', "Berhasil Mengubah Profile Pegawai: " . $request->nama_lengkap);
            return back();
        } else {
            alert()->error('Gagal!', "Gagal Mengubah Profile Pegawai: " . $request->nama_lengkap);
            return back()->withInput($request->all());
        }
    }
    // update keamanan
    private function updateKeamanan($request, $uuid_pegawai)
    {
        // auth
        $auth = Auth::user();
        $uuid_profile = $auth->uuid_profile;
        $data = Pegawai::findOrFail($uuid_pegawai);
        $username = $data->RelUser->username;

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
    // update hak akses
    private function updateHakAkses($request, $uuid_pegawai)
    {
        // auth
        $auth = Auth::user();
        $uuid_profile = $auth->uuid_profile;
        $data = Pegawai::findOrFail($uuid_pegawai);

        // cek sub_role
        if (isset($request->sub_role)) {
            // ada sub role
            // validate
            $request->validate([
                "sub_role" => "required|array|max:100",
            ]);

            // value_1
            $value_1 = [
                "sub_role" => implode(",", $request->sub_role),
                "uuid_updated" => $uuid_profile,
            ];

            // cek sub_role_ketua_tim
            if (in_array("Ketua Tim", $request->sub_role)) {
                // validate
                $request->validate([
                    "sub_role_ketua_tim" => "required|string|max:100",
                ]);
                $value_1['sub_sub_role'] = $request->sub_role_ketua_tim;
            } else {
                $value_1['sub_sub_role'] = null;
            }
        } else {
            // tidak ada sub role
            // value_1
            $value_1 = [
                "sub_role" => null,
                "sub_sub_role" => null,
                "uuid_updated" => $uuid_profile,
            ];
        }

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
                "subjek" => "Berhasil Mengubah Hak Akses Login Pegawai " . $data->nama_lengkap . " - " . $data->uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "1",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Berhasil!', 'Berhasil Mengubah Keamanan Hak Akses Login.');
            return back();
        } else {
            alert()->error('Gagal!', 'Gagal Mengubah Keamanan Hak Akses Login.');
            return back()->withInput($request->all());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(Request $request, $enc_uuid)
    {
        // uuid
        $uuid = CID::decode($enc_uuid);

        // data
        $data = Pegawai::findOrFail($uuid);

        // get data log
        $uuid_profile = $data->uuid;
        $logs_login = SysLogin::whereUuidProfile($uuid_profile)
            ->whereMonth("created_at", date('m'))
            ->orderBy("created_at", "DESC")
            ->get();
        $logs_aktifitas = SysLogAktifitas::whereUuidProfile($uuid_profile)
            ->whereMonth("created_at", date('m'))
            ->orderBy("created_at", "DESC")
            ->get();
        return view('pages.admin.settings_apps.pegawai.view_profile.profile', compact(
            'enc_uuid',
            'data',
            'logs_login',
            'logs_aktifitas',
        ));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // auth
        $auth = Auth::user();

        // uuid
        $uuid = CID::decode($request->uuid);

        // data
        $data = Pegawai::findOrFail($uuid);

        // save
        $save_1 = $data->delete();
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("pegawai"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Settings Apps",
                "subjek" => "Berhasil Menghapus Pegawai: " . $data->nama_lengkap . " - " . $uuid,
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
     * Status Aktif
     */
    public function status(Request $request)
    {
        // auth
        $auth = Auth::user();

        // uuid
        $uuid = CID::decode($request->uuid);
        $status = $request->status;
        if ($status == "0") {
            $status_update = "1";
        } else {
            $status_update = "0";
        }

        // data
        $data = User::findOrFail($uuid);

        // value
        $value_1 = [
            "status" => $status_update,
            "uuid_updated" => $auth->uuid_profile,
        ];

        // save
        $save_1 = $data->update($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("users"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Settings Apps",
                "subjek" => "Mengubah Status Pegawai: " . $data->RelPegawai->nama_lengkap . " - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "1",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            $msg = "Status Berhasil Diubah!";
            $response = [
                "status" => true,
                "message" => $msg,
            ];
            return response()->json($response, 200);
        } else {
            // success
            $msg = "Status Gagal Diubah!";
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
    public function data(Request $request)
    {
        $data = Pegawai::join("users", "users.uuid_profile", "=", "pegawai.uuid")
            ->select("pegawai.*", "users.role", "users.sub_role", "users.sub_sub_role", "users.status", "users.uuid as uuid_user")
            ->where("users.role", "Pegawai")
            ->orderBy("pegawai.nama_lengkap", "ASC")
            ->get();

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->setRowId('uuid')
                ->addColumn('detail', function ($data) {
                    $detail = '<p class="p-0 m-0"><strong>Status:</strong> ' . $data->status_pegawai . '</p>';
                    $detail .= '<p class="p-0 m-0"><strong>NIP:</strong> ' . $data->nip . '</p>';
                    $detail .= '<p class="p-0 m-0"><strong>Jabatan:</strong> ' . $data->jabatan . '</p>';
                    $detail .= '<p class="p-0 m-0"><strong>No. Telp/HP:</strong> ' . $data->no_telp . '</p>';
                    $detail .= '<p class="p-0 m-0"><strong>Email:</strong> ' . $data->email . '</p>';
                    return $detail;
                })
                ->addColumn('hak_akses', function ($data) {
                    $hak_akses = [];
                    $sub_role = $data->sub_role;
                    $ex_sub_role = explode(',', $sub_role);
                    $cex_sub_role = count($ex_sub_role);
                    for ($i = 0; $i < $cex_sub_role; $i++) {
                        $hak_akses[] = '<span class="badge badge-secondary me-1 mb-1">' . $ex_sub_role[$i] . '</span>';
                    }
                    return implode($hak_akses);
                })
                ->addColumn('status', function ($data) {
                    $uuid = CID::encode($data->uuid_user);
                    $subRoleSuperAdmin = CID::subRoleSuperAdmin();
                    if ($data->status == "1") {
                        $toogle = "checked";
                        $text = "Aktif";
                    } else {
                        $toogle = "";
                        $text = "Tidak Aktif";
                    }
                    if ($subRoleSuperAdmin == true) {
                        $status = '
                            <div class="form-check form-switch form-switch-custom form-switch-primary mb-3">
                                <input class="form-check-input" type="checkbox" role="switch" id="status" data-onclick="ubah-status" data-status="' . $uuid . '" data-status-value="' . $data->status . '" ' . $toogle . '>
                                <label class="form-check-label" for="status">' . $text . '</label>
                            </div>
                        ';
                    } else {
                        $status = '<label class="form-check-label" for="status">' . $text . '</label>';
                    }
                    return $status;
                })
                ->addColumn('aksi', function ($data) {
                    $enc_uuid = CID::encode($data->uuid);
                    $subRoleSuperAdmin = CID::subRoleSuperAdmin();
                    $edit = route('set.apps.pegawai.edit', [$enc_uuid]);
                    $show = route('set.apps.pegawai.show', [$enc_uuid]);
                    if ($subRoleSuperAdmin == true) {
                        $aksi = '<div class="dropdown">
                            <button class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="' . $edit . '"><i class="fa-solid fa-edit me-2"></i> Edit</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" data-delete="' . $enc_uuid . '"><i class="fa-solid fa-trash me-2"></i> Hapus</a></li>
                            </ul>
                            </div>';
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
