<?php

namespace App\Http\Controllers\WebBase\WebAdmin\auth;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PAProfileController extends Controller
{
    // index
    public function index()
    {
        // auth
        $data = Auth::user();
        return view('pages.admin.portal_apps.auth.profile', compact(
            'data'
        ));
    }

    // update
    public function update(Request $request)
    {
        // auth
        $auth = Auth::user();
        $username = $auth->username;
        $uuid_profile = $auth->uuid_profile;
        // validate
        $request->validate([
            "nama_lengkap" => "required|string|max:100",
            "nip" => "sometimes|nullable|max:100",
            "pangkat_golongan" => "sometimes|nullable|max:100",
            "jabatan" => "required|string|max:100",
            "jenis_kelamin" => "required|string|max:1",
            "email" => "required|string|max:100",
            "no_telp" => "required|string|max:100",
            "foto" => "sometimes|nullable|image|mimes:png,jpg,jpeg|max:1000",
            "username" => "required|string|max:100",
        ]);

        // return $request;
        // value_1 - pegawai
        $value_1 = [
            "nama_lengkap" => $request->nama_lengkap,
            "nip" => $request->nip,
            "pangkat_golongan" => $request->pangkat_golongan,
            "jabatan" => $request->jabatan,
            "jenis_kelamin" => $request->jenis_kelamin,
            "email" => Str::lower($request->email),
            "no_telp" => $request->no_telp,
            "uuid_updated" => $uuid_profile,
        ];

        // value_2 - users
        $new_username = $request->username;
        if ($new_username != $username) {
            // validate
            $request->validate([
                "username" => "required|unique:users,username|max:100",
            ]);
            $username = $new_username;
        }
        $value_2 = [
            "username" => $username,
            "uuid_updated" => $uuid_profile,
        ];
        if (isset($request->password)) {
            // validate
            $request->validate([
                "password" => "required|string|max:100",
            ]);
            $value_2['password'] = \bcrypt($request->password);
        }

        // foto
        $path = "users/" . $uuid_profile;
        if ($request->hasFile('foto')) {
            $img = CID::UpImg($request, "foto", $path);
            if ($img == "0") {
                alert()->error('Error!', 'Gagal Menyimpan Data, Foto Tidak Sesuai Format!');
                return \back();
            }
            $value_1['foto'] = $img;
        }

        // save
        $save_1 = Pegawai::whereUuid($uuid_profile)->update($value_1);
        $save_2 = User::whereUuidProfile($uuid_profile)->update($value_2);
        if ($save_1 && $save_2) {
            // create log
            $aktifitas = [
                "tabel" => array("pegawai", "users"),
                "uuid" => array($uuid_profile, $uuid_profile),
                "value" => array($value_1, $value_2),
            ];
            $log = [
                "apps" => "Portal Apps",
                "subjek" => "Mengubah Data Profile UUID= " . $uuid_profile,
                "aktifitas" => $aktifitas,
                "device" => "web",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Success', "Berhasil Mengubah Data!");
            return \redirect()->route('prt.apps.auth.profile.index');
        } else {
            alert()->error('Error', "Gagal Mengubah Data!");
            return \back()->withInput($request->all());
        }
    }
}
