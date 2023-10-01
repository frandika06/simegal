<?php

namespace App\Http\Controllers\ApiBase\ApiAdmin\auth;

use App\Http\Controllers\Controller;
use App\Models\SysFailedLogin;
use App\Models\SysLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LoginApiController extends Controller
{
    // index
    public function index()
    {
        // response validasi
        $response = [
            "status" => false,
            "message" => "Unauthorized!",
        ];
        return response()->json($response, 401);
    }

    // Store Login
    public function store(Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:100',
            'password' => 'required|max:100',
        ]);

        // response validasi
        $response = [
            "status" => false,
            "message" => "Validation Error!!",
            "errors" => $validator->errors(),
        ];
        if ($validator->fails()) {
            return response()->json($response, 422);
        }

        // request
        $username = $request->username;
        $credentials = request(['username', 'password']);
        if (!Auth::attempt($credentials)) {
            // user tidak ditemukan
            $response = [
                "status" => false,
                "message" => "Username / Password Anda Salah!",
            ];
            //Failed Login
            $FailedLogin = [
                'uuid' => Str::uuid(),
                'username' => $username,
                'ip' => $request->ip(),
                "agent" => $request->header('user-agent'),
                "status" => "Gagal Login, Username / Password Anda Tidak Ditemukan!",
                "device" => "mobile",
            ];
            SysFailedLogin::create($FailedLogin);
            return response()->json($response, 422);
        }

        // user ditemukan
        $user = $request->user();

        // cek status
        if ($user->status == 0) {
            $response = [
                "status" => false,
                "message" => "Akun Sudah di Non-aktifkan!",
            ];
            //Failed Login
            $FailedLogin = [
                'uuid' => Str::uuid(),
                'username' => $username,
                'ip' => $request->ip(),
                "agent" => $request->header('user-agent'),
                "status" => "Gagal Login, Akun Sudah di Non-aktifkan!",
                "device" => "mobile",
            ];
            SysFailedLogin::create($FailedLogin);
            return response()->json($response, 422);
        }

        // cek dihapus
        if ($user->trashed()) {
            $response = [
                "status" => false,
                "message" => "Akun Tidak Ditemukan/Deleted!",
            ];
            //Failed Login
            $FailedLogin = [
                'uuid' => Str::uuid(),
                'username' => $username,
                'ip' => $request->ip(),
                "agent" => $request->header('user-agent'),
                "status" => "Gagal Login, Akun Tidak Ditemukan/Deleted!",
                "device" => "mobile",
            ];
            SysFailedLogin::create($FailedLogin);
            return response()->json($response, 422);
        }

        // berhasil login dan buat token
        $tokenResult = $user->createToken($user->uuid_profile);
        $token = $tokenResult->token;

        // cek remember me
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        // simpan token
        $token->save();

        //Success Login
        $SuccessLogin = [
            'uuid' => Str::uuid(),
            'uuid_profile' => $user->uuid_profile,
            'ip' => $request->ip(),
            "agent" => $request->header('user-agent'),
            "status" => "Akun " . $username . " Login ke Aplikasi melalui Mobile",
            "device" => "mobile",
        ];
        SysLogin::create($SuccessLogin);

        return response()->json([
            "status" => true,
            "message" => "Anda Berhasil Login!",
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
        ]);
    }

    // Store Logout
    public function logout(Request $request)
    {
        if ($request->user()) {
            // get user
            $user = $request->user();
            //Success Logout
            $SuccessLogin = [
                'uuid' => Str::uuid(),
                'uuid_profile' => $user->uuid_profile,
                'ip' => $request->ip(),
                "agent" => $request->header('user-agent'),
                "status" => "Akun " . $user->username . " Logout dari Aplikasi melalui Mobile",
                "device" => "mobile",
            ];
            SysLogin::create($SuccessLogin);

            // Revoke
            $result = $request->user()->token()->revoke();
            if ($result) {
                $response = [
                    "status" => true,
                    "message" => "Anda Berhasil Logout!",
                ];
                return response()->json($response, 200);
            } else {
                $response = [
                    "status" => false,
                    "message" => "Terjadi Kesalahan!",
                ];
                return response()->json($response, 422);
            }
            return $response;
        } else {
            $response = [
                "status" => false,
                "message" => $request->user()->id,
            ];
            return response()->json($response, 422);
        }
    }
}
