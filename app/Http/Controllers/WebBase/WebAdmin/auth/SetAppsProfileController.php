<?php

namespace App\Http\Controllers\WebBase\WebAdmin\auth;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\SysLogAktifitas;
use App\Models\SysLogin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SetAppsProfileController extends Controller
{
    //index
    public function index()
    {
        // auth
        $auth = Auth::user();
        $uuid = $auth->uuid_profile;

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
        return view('pages.admin.settings_apps.auth.profile', compact(
            'data',
            'logs_login',
            'logs_aktifitas',
        ));
    }

    // update
    public function update(Request $request)
    {
        // auth
        $auth = Auth::user();
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
                "dashboard" => "0",
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
            "old_password" => "required|string|max:100",
            "new_password" => "required|string|max:100",
        ]);

        // value_1
        $new_username = $request->username;
        $old_password = $request->old_password;
        $new_password = $request->new_password;

        // cek password lama
        if (!Hash::check($old_password, $data->RelUser->password)) {
            // password lama salah
            alert()->error('Gagal!', 'Password Lama Salah!');
            return back()->withInput($request->all());
        }

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
                "dashboard" => "0",
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
}
