<?php

namespace App\Http\Controllers\WebBase\WebAdmin\auth;

use App\Http\Controllers\Controller;
use App\Models\SysFailedLogin;
use App\Models\SysLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    // index
    public function index(Request $request)
    {
        return view('pages.auth.login');
    }

    // store
    public function store(Request $request)
    {
        // validate
        $request->validate([
            "username" => "required|string|max:100",
            "password" => "required|string|max:100",
        ]);

        //Submit Login
        $username = $request->input('username');
        $remember_me = $request->has('remember_me') ? true : false;
        if (auth()->attempt(['username' => $username, 'password' => $request->input('password')], $remember_me)) {
            $user = auth()->user();
            if ($user->status == "1") {
                if ($user->trashed()) {
                    //User Telah Dihapus
                    //Failed Login
                    $FailedLogin = [
                        'uuid' => Str::uuid(),
                        'username' => $username,
                        'ip' => $request->ip(),
                        "agent" => $request->header('user-agent'),
                        "status" => "Gagal Login, Akun User Sudah Dihapus!",
                        "device" => "web",
                    ];
                    SysFailedLogin::create($FailedLogin);
                    Auth::logout();
                    alert()->error('Gagal Login!', 'Username/Password Yang Anda Masukkan Salah!');
                    return \back()->withInput($request->only('username'));
                } else {
                    //Success Login
                    $SuccessLogin = [
                        'uuid' => Str::uuid(),
                        'uuid_profile' => $user->uuid_profile,
                        'ip' => $request->ip(),
                        "agent" => $request->header('user-agent'),
                        "status" => "Akun " . $username . " Login ke Aplikasi melalui Website",
                        "device" => "web",
                    ];
                    SysLogin::create($SuccessLogin);
                    //User Aktif
                    return \redirect()->route('auth.home');
                }
            } else {
                //User Tidak Aktif
                //Failed Login
                $FailedLogin = [
                    'uuid' => Str::uuid(),
                    'username' => $username,
                    'ip' => $request->ip(),
                    "agent" => $request->header('user-agent'),
                    "status" => "Gagal Login, Akun User Sudah Di Non-Aktifkan!",
                    "device" => "web",
                ];
                SysFailedLogin::create($FailedLogin);
                Auth::logout();
                alert()->error('Gagal Login!', 'Akun Anda Sudah Di Non-Aktifkan!');
                return \back()->withInput($request->only('username'));
            }
        } else {
            //Failed Login
            $FailedLogin = [
                'uuid' => Str::uuid(),
                'username' => $username,
                'ip' => $request->ip(),
                "agent" => $request->header('user-agent'),
                "status" => "Gagal Login, Username/Password Salah!",
                "device" => "web",
            ];
            SysFailedLogin::create($FailedLogin);
            alert()->error('Gagal Login!', 'Username/Password Yang Anda Masukkan Salah!');
            return \back()->withInput($request->only('username'));
        }
    }

    // logout
    public function logout(Request $request)
    {
        $user = Auth::user();
        //Success Logout
        $SuccessLogout = [
            'uuid' => Str::uuid(),
            'uuid_profile' => $user->uuid_profile,
            'ip' => $request->ip(),
            "agent" => $request->header('user-agent'),
            "status" => "Akun " . $user->username . " Logout dari Aplikasi melalui Website",
            "device" => "web",
        ];
        SysLogin::create($SuccessLogout);
        Auth::logout();
        alert()->success('Success!', 'Anda Berhasil Logout!');
        return \redirect()->route('prt.lgn.index');
    }
}
