<?php

namespace App\Http\Controllers\WebBase\WebAdmin\configs;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BaseAppsController extends Controller
{
    public function index()
    {
        // auth
        $auth = Auth::user();
        $role = $auth->role;
        $sub_role = $auth->sub_role;
        $sub_sub_role = $auth->sub_sub_role;

        // Admin System
        if ($role == "Admin System") {
            return "Admin System";
        } elseif ($role == "Pegawai") {
            // PEGAWAI
            if ($sub_role == "Admin Portal") {
                return \redirect()->route('prt.apps.home.index');
            } else {
                return \abort(404);
            }
        } else {
            return \abort(404);
        }
    }
}
