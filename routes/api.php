<?php

use App\Http\Controllers\ApiBase\ApiAdmin\auth\ApiPDPProfileController;
use App\Http\Controllers\ApiBase\ApiAdmin\auth\LoginApiController;
use App\Http\Controllers\ApiBase\ApiAdmin\auth\RegisterApiController;
use App\Http\Controllers\ApiBase\ApiAdmin\configs\ApiDropdownsController;
use App\Http\Controllers\ApiBase\ApiAdmin\PdpApps\dashboard\ApiPDPDashboardController;
use App\Http\Controllers\ApiBase\ApiAdmin\PdpApps\permohonan\ApiPDPPermohonanPeneraanController;
use App\Http\Controllers\ApiBase\ApiAdmin\PdpApps\retribusi\ApiPDPRetribusiController;
use App\Http\Controllers\ApiBase\ApiAdmin\PdpApps\sertifikat\ApiPDPSertifikatController;
use App\Http\Controllers\ApiBase\ApiAdmin\PortalApps\ApiPortalAppsController;
use App\Http\Controllers\ApiBase\ApiAdmin\ScheduleApps\penera\ApiScdDataPdpController;
use App\Http\Controllers\ApiBase\ApiAdmin\ScheduleApps\penera\ApiScdInstrumenAlatController;
use App\Http\Controllers\ApiBase\ApiAdmin\SettingsApps\auth\ApiSetAppsProfileController;
use App\Http\Controllers\ApiBase\ApiAdmin\SettingsApps\master\ApiSetAppsFiturController;
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
| API DROPDOWNS
| PATH : ApiBase/ApiAdmin/configs
|--------------------------------------------------------------------------
 */
Route::group(['prefix' => 'dd'], function () {
    Route::get('/get-alamat-perusahaan/{uuid}', [ApiDropdownsController::class, 'getAlamatPerusahaan']);
    Route::get('/get-list-tahun-permohonan', [ApiDropdownsController::class, 'getListTahunPermohonan']);
    Route::get('/get-list-instrumen-group', [ApiDropdownsController::class, 'getListInstrumenGroup']);
    Route::get('/get-list-instrumen-item-uttp/{uuid}', [ApiDropdownsController::class, 'getListInstrumenItemUttp']);
    Route::get('/get-list-alat/{tags}/{uuid}', [ApiDropdownsController::class, 'getListAlat']);
});

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
 */
Route::group(['middleware' => ['auth:api', 'LastSeen', 'MobileFECounter']], function () {
    // AUTH
    Route::group(['prefix' => 'auth'], function () {
        Route::get('/logout', [LoginApiController::class, 'logout']);
    });

    /*
    |--------------------------------------------------------------------------
    | PORTAL APPS
    | PATH : ApiBase/ApiAdmin/PortalApps
    |--------------------------------------------------------------------------
     */
    Route::group(['prefix' => 'portal-apps'], function () {
        Route::get('/post/{page?}/{tags?}', [ApiPortalAppsController::class, 'postingan']);
        Route::get('/unduhan/{page?}/{tags?}', [ApiPortalAppsController::class, 'unduhan']);
        // read
        Route::group(['prefix' => 'read'], function () {
            Route::get('/post/{uuid}', [ApiPortalAppsController::class, 'readPostingan']);
            Route::get('/unduhan/{uuid}', [ApiPortalAppsController::class, 'readUnduhan']);
        });
    });

    /*
    |--------------------------------------------------------------------------
    | PENJADWALAN DAN PENUGASAN (PDP) APPS - ROLE PERUSAHAAN (PdpApps)
    | PATH : ApiBase/ApiAdmin/PdpApps
    |--------------------------------------------------------------------------
     */
    Route::group(['prefix' => 'pdp-apps'], function () {
        // middleware : Perusahaan
        Route::group(['middleware' => ['Perusahaan']], function () {
            // auth
            // PATH : ApiBase/ApiAdmin/auth
            Route::group(['prefix' => 'auth'], function () {
                Route::get('/profile', [ApiPDPProfileController::class, 'index']);
                Route::post('/profile', [ApiPDPProfileController::class, 'update']);
                Route::get('/alamat/{uuid}', [ApiPDPProfileController::class, 'showAlamat']);
                Route::delete('/alamat', [ApiPDPProfileController::class, 'destroy']);
            });

            // dashboard
            // PATH : ApiBase/ApiAdmin/PdpApps/dashboard
            Route::group(['prefix' => 'dashboard'], function () {
                Route::get('/{tahun}/{status}', [ApiPDPDashboardController::class, 'index']);
            });

            // permohonan
            // PATH : ApiBase/ApiAdmin/PdpApps/permohonan
            Route::group(['prefix' => 'permohonan'], function () {
                Route::post('/create', [ApiPDPPermohonanPeneraanController::class, 'store']);
                Route::put('/edit/{uuid}', [ApiPDPPermohonanPeneraanController::class, 'update']);
                Route::get('/show/{uuid}', [ApiPDPPermohonanPeneraanController::class, 'show']);
                Route::delete('/delete', [ApiPDPPermohonanPeneraanController::class, 'destroy']);
            });

            // middleware : ProtectFiturRetribusi
            Route::group(['middleware' => ['ProtectFiturRetribusi']], function () {
                // retribusi
                // PATH : ApiBase/ApiAdmin/PdpApps/retribusi
                Route::group(['prefix' => 'retribusi'], function () {
                    Route::get('/', [ApiPDPRetribusiController::class, 'index']);
                    Route::post('/create/{uuid}', [ApiPDPRetribusiController::class, 'store']);
                });
            });

            // sertifikat
            // PATH : ApiBase/ApiAdmin/PdpApps/sertifikat
            Route::group(['prefix' => 'sertifikat'], function () {
                Route::get('/', [ApiPDPSertifikatController::class, 'index']);
            });
        });
    });

    /*
    |--------------------------------------------------------------------------
    | PENJADWALAN DAN PENUGASAN (PDP) APPS - ADMIN (ScheduleApps)
    | PATH : ApiBase/ApiAdmin/ScheduleApps
    |--------------------------------------------------------------------------
     */
    Route::group(['prefix' => 'schedule-apps'], function () {
        // middleware : Petugas
        Route::group(['middleware' => ['Petugas']], function () {
            // jadwal-penugasan
            // PATH : ApiBase/ApiAdmin/ScheduleApps/penera
            Route::group(['prefix' => 'jadwal-penugasan'], function () {
                Route::get('/{tahun}/{status}/{tags}', [ApiScdDataPdpController::class, 'index']);
                Route::get('/show/{uuid}', [ApiScdDataPdpController::class, 'show']);
                // middleware : PetugasOnly
                Route::group(['middleware' => ['PetugasOnly']], function () {
                    Route::put('/status', [ApiScdDataPdpController::class, 'status']);
                });
            });

            // instrumen-alat
            // PATH : ApiBase/ApiAdmin/ScheduleApps/penera
            Route::group(['prefix' => 'instrumen-alat'], function () {
                Route::get('/{tahun}/{status}/{tags}', [ApiScdInstrumenAlatController::class, 'index']);
                Route::get('/show/{uuid}', [ApiScdInstrumenAlatController::class, 'show']);
                // middleware : PetugasOnly
                Route::group(['middleware' => ['PetugasOnly']], function () {
                    Route::put('/update/{uuid}', [ApiScdInstrumenAlatController::class, 'update']);
                });
            });

            // tindak-lanjut
            // PATH : ApiBase/ApiAdmin/ScheduleApps/penera
            Route::group(['prefix' => 'tindak-lanjut'], function () {
                Route::get('/{tags_jp}/{tahun}/{status}/{tags}', [ApiScdInstrumenAlatController::class, 'index']);
                // middleware : PetugasOnly
                Route::group(['middleware' => ['PetugasOnly']], function () {
                    Route::put('/update/{uuid}', [ApiScdInstrumenAlatController::class, 'update']);
                });
            });
        });
    });

    /*
    |--------------------------------------------------------------------------
    | PENGATURAN APPS
    | PATH : ApiBase/ApiAdmin/SettingsApps
    |--------------------------------------------------------------------------
     */
    Route::group(['prefix' => 'settings-apps'], function () {
        // master
        // PATH : ApiBase/ApiAdmin/SettingsApps/master
        Route::group(['prefix' => 'master'], function () {
            // fitur
            Route::group(['prefix' => 'fitur'], function () {
                Route::get('/{nama_fitur}', [ApiSetAppsFiturController::class, 'index']);
            });
        });

        // middleware : Pegawai
        Route::group(['middleware' => ['Pegawai']], function () {
            // auth
            // PATH : ApiBase/ApiAdmin/SettingsApps/auth
            Route::group(['prefix' => 'profile'], function () {
                Route::get('/', [ApiSetAppsProfileController::class, 'index']);
                Route::put('/', [ApiSetAppsProfileController::class, 'update']);
            });
        });
    });
});