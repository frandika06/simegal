<?php

namespace App\Http\Controllers\WebBase\WebAdmin\auth;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    // index
    public function index(Request $request)
    {
        return view('pages.auth.register');
    }

    // store
    public function store(Request $request)
    {
        // validate
        $request->validate([
            "jenis_perusahaan" => "required|string|max:100",
            "nama_perusahaan" => "required|string|max:100",
            "nama_pic" => "required|string|max:100",
            "npwp" => "required|string|max:100",
            "email" => "required|string|max:100",
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
        ];

        // value user
        $uuid = Str::uuid();
        $value_2 = [
            "uuid" => $uuid,
            "uuid_profile" => $uuid_profile,
            "username" => $request->username,
            "password" => bcrypt($request->password),
            "role" => "Perusahaan",
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
                "apps" => "Penjadwalan dan Penugasan Apps",
                "subjek" => "Menambahkan Data Master Kategori UUID= " . $uuid,
                "aktifitas" => $aktifitas,
                "role" => "Perusahaan",
                "device" => "web",
                "dashboard" => "1",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Success', "Berhasil Mendaftarkan Akun " . $jp);
            return \redirect()->route('prt.lgn.index');
        } else {
            alert()->error('Error', "Gagal Mendaftarkan Akun " . $jp);
            return \back()->withInput($request->all());
        }

    }
}
