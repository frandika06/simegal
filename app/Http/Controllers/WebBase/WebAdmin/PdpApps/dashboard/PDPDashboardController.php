<?php

namespace App\Http\Controllers\WebBase\WebAdmin\PdpApps\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PDPDashboardController extends Controller
{
    // index
    public function index()
    {
        // auth
        $auth = Auth::user();
        $profile = $auth->RelPerusahaan;
        return view('pages.admin.pdp_apps.dashboard.index', compact(
            'profile'
        ));
    }
}
