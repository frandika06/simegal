<?php

use App\Http\Controllers\ApiBase\ApiAdmin\auth\ApiPDPProfileController;
use App\Http\Controllers\ApiBase\ApiAdmin\auth\LoginApiController;
use App\Http\Controllers\ApiBase\ApiAdmin\auth\RegisterApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

/*
|--------------------------------------------------------------------------
| PORTAL
| PATH : ApiBase/ApiAdmin
|--------------------------------------------------------------------------
 */

Route::get('/', function () {
    $response = [
        "apps" => "REST API Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang",
        "author" => "Dinas Perindustrian dan Perdagangan Kabupaten Tangerang",
        "version" => "2.0",
        "date_build" => "Juni 2023",
    ];
    return response()->json($response, 200);
})->name('api.index');

// GUEST ONLY
Route::group(['middleware' => ['guest:api']], function () {
    // AUTH
    Route::group(['prefix' => 'auth'], function () {
        Route::get('/login', [LoginApiController::class, 'index'])->name('api.lgn.index');
        Route::post('/login', [LoginApiController::class, 'store']);
        Route::post('/register', [RegisterApiController::class, 'store']);
    });
});

// export-import
Route::group(['prefix' => 'exim'], function () {
    //
});

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
 */
Route::group(['middleware' => ['auth:api', 'LastSeen']], function () {
    // AUTH
    Route::group(['prefix' => 'auth'], function () {
        Route::get('/logout', [LoginApiController::class, 'logout']);
    });

    /*
    |--------------------------------------------------------------------------
    | PENJADWALAN DAN PENUGASAN (PDP) APPS
    | PATH : ApiBase/ApiAdmin/PdpApps
    |--------------------------------------------------------------------------
     */
    Route::group(['prefix' => 'pdp-apps'], function () {
        // auth
        // PATH : ApiBase/ApiAdmin/auth
        Route::group(['prefix' => 'auth'], function () {
            Route::get('/profile', [ApiPDPProfileController::class, 'index']);
            Route::post('/profile', [ApiPDPProfileController::class, 'update']);
            Route::get('/alamat/{uuid}', [ApiPDPProfileController::class, 'showAlamat']);
            Route::delete('/alamat', [ApiPDPProfileController::class, 'destroy']);
        });
    });
});
