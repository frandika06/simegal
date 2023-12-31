<?php

use App\Http\Controllers\WebBase\WebAdmin\auth\LoginController;
use App\Http\Controllers\WebBase\WebAdmin\auth\PAProfileController;
use App\Http\Controllers\WebBase\WebAdmin\auth\PDPProfileController;
use App\Http\Controllers\WebBase\WebAdmin\auth\RegisterController;
use App\Http\Controllers\WebBase\WebAdmin\auth\SetAppsProfileController;
use App\Http\Controllers\WebBase\WebAdmin\configs\BaseAppsController;
use App\Http\Controllers\WebBase\WebAdmin\PdpApps\dashboard\PDPDashboardController;
use App\Http\Controllers\WebBase\WebAdmin\PdpApps\permohonan\PDPPermohonanPeneraanController;
use App\Http\Controllers\WebBase\WebAdmin\PdpApps\retribusi\PDPRetribusiController;
use App\Http\Controllers\WebBase\WebAdmin\PdpApps\sertifikat\PDPSertifikatSKHPController;
use App\Http\Controllers\WebBase\WebAdmin\PortalApps\dashboard\PADashboardController;
use App\Http\Controllers\WebBase\WebAdmin\PortalApps\kontak\PAPesanController;
use App\Http\Controllers\WebBase\WebAdmin\PortalApps\master\PAKategoriController;
use App\Http\Controllers\WebBase\WebAdmin\PortalApps\master\PASetupController;
use App\Http\Controllers\WebBase\WebAdmin\PortalApps\master\PASosmedController;
use App\Http\Controllers\WebBase\WebAdmin\PortalApps\posts\PABannerController;
use App\Http\Controllers\WebBase\WebAdmin\PortalApps\posts\PAFAQController;
use App\Http\Controllers\WebBase\WebAdmin\PortalApps\posts\PAFotoController;
use App\Http\Controllers\WebBase\WebAdmin\PortalApps\posts\PAGaleriController;
use App\Http\Controllers\WebBase\WebAdmin\PortalApps\posts\PAHalamanController;
use App\Http\Controllers\WebBase\WebAdmin\PortalApps\posts\PAPostinganController;
use App\Http\Controllers\WebBase\WebAdmin\PortalApps\posts\PAStatistikController;
use App\Http\Controllers\WebBase\WebAdmin\PortalApps\posts\PAUnduhanController;
use App\Http\Controllers\WebBase\WebAdmin\PortalApps\posts\PAVideoController;
use App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\dashboard\ScdDashboardController;
use App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\penera\ScdDataPdpController;
use App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\penera\ScdInstrumenAlatController;
use App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\permohonan\ScdInputDataPdpController;
use App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\permohonan\ScdPermohonanPengujianController;
use App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\tinjut\action\ScdTinjutActionBaController;
use App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\tinjut\action\ScdTinjutActionCerapanController;
use App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\tinjut\action\ScdTinjutActionDokumentasiController;
use App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\tinjut\action\ScdTinjutActionRetribusiController;
use App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\tinjut\action\ScdTinjutActionSkhpController;
use App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\tinjut\ScdTinjutBdktController;
use App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\tinjut\ScdTinjutMTController;
use App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\tinjut\ScdTinjutUapvController;
use App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\tte\ScdTteSkhpController;
use App\Http\Controllers\WebBase\WebAdmin\SettingsApps\dashboard\SetAppsDashboardController;
use App\Http\Controllers\WebBase\WebAdmin\SettingsApps\kabid\SetAppsKabidController;
use App\Http\Controllers\WebBase\WebAdmin\SettingsApps\kadis\SetAppsKadisController;
use App\Http\Controllers\WebBase\WebAdmin\SettingsApps\master\SetAppsFiturController;
use App\Http\Controllers\WebBase\WebAdmin\SettingsApps\master\SetAppsSuperAdminController;
use App\Http\Controllers\WebBase\WebAdmin\SettingsApps\master\uttp\SetAppsInsUttpDaftarItemController;
use App\Http\Controllers\WebBase\WebAdmin\SettingsApps\master\uttp\SetAppsInsUttpJenisController;
use App\Http\Controllers\WebBase\WebAdmin\SettingsApps\master\uttp\SetAppsUttpJenisPelayananController;
use App\Http\Controllers\WebBase\WebAdmin\SettingsApps\master\uttp\SetAppsUttpKelompokController;
use App\Http\Controllers\WebBase\WebAdmin\SettingsApps\master\uttp\SetAppsUttpTagsKelompokController;
use App\Http\Controllers\WebBase\WebAdmin\SettingsApps\pegawai\SetAppsPegawaiController;
use App\Http\Controllers\WebBase\WebAdmin\SettingsApps\perusahaan\SetAppsPerusahaanController;
use App\Http\Controllers\WebBase\WebAdmin\SupervisionApps\dashboard\SpvDashboardController;
use App\Http\Controllers\WebBase\WebAdmin\SupervisionApps\pp\SpvPPPemantauanController;
use App\Http\Controllers\WebBase\WebConfigs\AjaxController;
use App\Http\Controllers\WebBase\WebConfigs\CekTteController;
use App\Http\Controllers\WebBase\WebConfigs\ExDownController;
use App\Http\Controllers\WebBase\WebConfigs\NocController;
use App\Http\Controllers\WebBase\WebConfigs\PrintPdpController;
use App\Http\Controllers\WebBase\WebConfigs\WilAdmController;
use App\Http\Controllers\WebBase\WebPortal\HomeController;
use App\Http\Controllers\WebBase\WebPortal\MediaController;
use App\Http\Controllers\WebBase\WebPortal\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

/*
|--------------------------------------------------------------------------
| Portal
|--------------------------------------------------------------------------
 */

Route::group(['middleware' => ['WebFECounter']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('prt.home.index');
    Route::group(['prefix' => 'portal'], function () {
        // post
        Route::get('/post/{tags}', [PostController::class, 'index'])->name('prt.post.index');
        Route::get('/post/{tags}/{slug}', [PostController::class, 'readPost'])->name('prt.post.read');
        // static-page
        Route::get('/page/{slug}', [PostController::class, 'staticPage'])->name('prt.page.index');
        // media-unduhan
        Route::group(['prefix' => 'unduhan'], function () {
            Route::get('/{tags?}', [MediaController::class, 'tagsUnduhan'])->name('prt.media.unduh.tags');
            Route::get('/read/{slug}', [MediaController::class, 'readUnduhan'])->name('prt.media.unduh.read');
        });
        // media-galeri
        Route::group(['prefix' => 'galeri'], function () {
            Route::get('/', [MediaController::class, 'indexGaleri'])->name('prt.media.gallery.index');
            Route::get('/read/{slug}', [MediaController::class, 'readGaleri'])->name('prt.media.gallery.read');
        });
        // media-video
        Route::group(['prefix' => 'video'], function () {
            Route::get('/', [MediaController::class, 'indexVideo'])->name('prt.media.video.index');
            Route::get('/read/{slug}', [MediaController::class, 'readVideo'])->name('prt.media.video.read');
        });
        // kirim-pesan
        Route::post('/kirim-pesan', [PostController::class, 'kirimPesan'])->name('prt.kirim.pesan');
        // search
        Route::get('/search', [PostController::class, 'searchPost'])->name('prt.q.index');
    });

    // GUEST ONLY
    Route::group(['middleware' => ['pbh', 'guest']], function () {
        Route::group(['prefix' => 'auth'], function () {
            Route::get('/login', [LoginController::class, 'index'])->name('prt.lgn.index'); Route::post('/login', [LoginController::class, 'store'])->name('prt.lgn.post');
            Route::get('/register', [RegisterController::class, 'index'])->name('prt.reg.index');
            Route::post('/register', [RegisterController::class, 'store'])->name('prt.reg.post');
            // Route::get('/reset', [ResetController::class, 'index'])->name('prt.rst.index');
            // Route::post('/reset', [ResetController::class, 'store'])->name('prt.rst.post');
            // Route::get('/reset/{uuid}', [ResetController::class, 'edit'])->name('prt.rst.edit');
            // Route::put('/reset/{uuid}', [ResetController::class, 'update'])->name('prt.rst.update');
        });
    });
});

/*
|--------------------------------------------------------------------------
| WEB CONFIGS
| PATH : WebBase/WebConfigs
|--------------------------------------------------------------------------
 */
// wilayah-administrasi
Route::group(['prefix' => 'wil-adm'], function () {
    Route::group(['prefix' => 'data'], function () {
        Route::get('/prov', [WilAdmController::class, 'dataProvinsi'])->name('wiladm.data.prov');
        Route::get('/kab/{id}', [WilAdmController::class, 'dataKabupaten'])->name('wiladm.data.kab');
        Route::get('/kec/{id}', [WilAdmController::class, 'dataKecamatan'])->name('wiladm.data.kec');
        Route::get('/desa/{id}', [WilAdmController::class, 'dataDesa'])->name('wiladm.data.desa');
    });
    Route::group(['prefix' => 'detail'], function () {
        Route::get('/prov/{id}', [WilAdmController::class, 'detailProvinsi'])->name('wiladm.detail.prov');
        Route::get('/kab/{id}', [WilAdmController::class, 'detailKabupaten'])->name('wiladm.detail.kab');
        Route::get('/kec/{id}', [WilAdmController::class, 'detailKecamatan'])->name('wiladm.detail.kec');
        Route::get('/desa/{id}', [WilAdmController::class, 'detailDesa'])->name('wiladm.detail.desa');
    });
    Route::group(['prefix' => 'substr'], function () {
        Route::get('/prov/{start}/{extract}/{id}', [WilAdmController::class, 'substrProvinsi'])->name('wiladm.substr.prov');
        Route::get('/kab/{start}/{extract}/{id}', [WilAdmController::class, 'substrKabupaten'])->name('wiladm.substr.kab');
        Route::get('/kec/{start}/{extract}/{id}', [WilAdmController::class, 'substrKecamatan'])->name('wiladm.substr.kec');
        Route::get('/desa/{start}/{extract}/{id}', [WilAdmController::class, 'substrDesa'])->name('wiladm.substr.desa');
    });

});

/*
|--------------------------------------------------------------------------
| eximdown | Export - Import - Download
| PATH : WebBase/WebConfigs
|--------------------------------------------------------------------------
 */
Route::group(['prefix' => 'eximdown'], function () {
    // unduhan
    Route::get('/unduhan/{uuid}', [ExDownController::class, 'unduhan'])->name('exdown.unduh');
    Route::get('/unduh-skhp/{kode_tte}', [ExDownController::class, 'unduhSkhp'])->name('exdown.unduh.skhp');
    Route::get('/unduh-cerapan/{uuid}', [ExDownController::class, 'unduhCerapan'])->name('exdown.unduh.cerapan');
    Route::get('/unduh-ba/{uuid}', [ExDownController::class, 'unduhBa'])->name('exdown.unduh.ba');
    Route::get('/unduh-dokumentasi/{uuid}', [ExDownController::class, 'unduhDokumentasi'])->name('exdown.unduh.dok');
    // settings-apps
    Route::group(['prefix' => 'settings-apps'], function () {
        // exxport
        Route::get('/master/ex-format-master-item-uttp', [ExDownController::class, 'SetExFormatMasterItemUttp'])->name('exdown.set.mst.item.uttp');
        // exxport
        Route::post('/master/im-format-master-item-uttp', [ExDownController::class, 'SetImFormatMasterItemUttp'])->name('eximp.set.mst.item.uttp');
    });
});

/*
|--------------------------------------------------------------------------
| PRINT
| PATH : WebBase/WebConfigs
|--------------------------------------------------------------------------
 */
Route::group(['prefix' => 'print'], function () {
    // pdp | Aplikasi Penjadwalan dan Penugasan
    Route::group(['prefix' => 'pdp'], function () {
        Route::get('/surat-jalan/{uuid}', [PrintPdpController::class, 'suratJalan'])->name('print.pdp.sj');
        Route::get('/surat-perintah/{uuid}', [PrintPdpController::class, 'suratPerintah'])->name('print.pdp.spt');
        Route::get('/kartu-penerus-disposisi/{uuid}', [PrintPdpController::class, 'kartuPenerusDisposisi'])->name('print.pdp.disposisi');
        Route::get('/surat-keterangan-retribusi/{uuid}', [PrintPdpController::class, 'suratKeteranganRetribusi'])->name('print.pdp.skrd');
    });
});

/*
|--------------------------------------------------------------------------
| TTE
| PATH : WebBase/WebConfigs
|--------------------------------------------------------------------------
 */
Route::group(['prefix' => 'tte'], function () {
    Route::get('/skhp/{kode_tte}', [CekTteController::class, 'indexSkhp'])->name('cek.tte.skhp');
    Route::get('/skrd/{uuid}', [CekTteController::class, 'indexSkrd'])->name('cek.tte.skrd');
});

/*
|--------------------------------------------------------------------------
| AJAX
| PATH : WebBase/WebConfigs
|--------------------------------------------------------------------------
 */
Route::group(['prefix' => 'ajax'], function () {
    // settings-apps
    Route::group(['prefix' => 'settings-apps'], function () {
        Route::post('/master/get-kelompok-uttp', [AjaxController::class, 'SetGetKelompokUttp'])->name('ajax.set.apps.get.klpk.uttp');
    });
    // schedule-apps
    Route::group(['prefix' => 'schedule-apps'], function () {
        // statistik
        Route::group(['prefix' => 'statistik'], function () {
            Route::post('/permohonan-pengujian', [AjaxController::class, 'ScdStatistikPermohonan'])->name('ajax.scd.apps.sts.pp');
            Route::post('/input-data', [AjaxController::class, 'ScdStatistikInputData'])->name('ajax.scd.apps.sts.input.pdp');
            Route::post('/penugasan', [AjaxController::class, 'ScdStatistikPenugasan'])->name('ajax.scd.apps.sts.penugasan');
            Route::post('/insalat', [AjaxController::class, 'ScdStatistikInsAlat'])->name('ajax.scd.apps.sts.insalat');
            Route::post('/tinjut-mt', [AjaxController::class, 'ScdStatistikTinjutMT'])->name('ajax.scd.apps.sts.tinjut.mt');
            Route::post('/tinjut-uapv', [AjaxController::class, 'ScdStatistikTinjutUapv'])->name('ajax.scd.apps.sts.tinjut.uapv');
            Route::post('/tinjut-bdkt', [AjaxController::class, 'ScdStatistikTinjutBdkt'])->name('ajax.scd.apps.sts.tinjut.bdkt');
            Route::post('/tte/data-skhp', [AjaxController::class, 'ScdTteDokumenSKHP'])->name('ajax.scd.apps.sts.tte.skhp');
            Route::post('/tte/get-pejabat', [AjaxController::class, 'SetGetTtePejabat'])->name('ajax.scd.apps.tte.get.pejabat');
        });
        // form
        Route::group(['prefix' => 'form'], function () {
            Route::post('/file-cerapan', [AjaxController::class, 'FormGetFileCerapan'])->name('ajax.scd.apps.form.get.file.cerapan');
            Route::post('/file-ba', [AjaxController::class, 'FormGetFileBa'])->name('ajax.scd.apps.form.get.file.ba');
            Route::post('/file-dokumentasi', [AjaxController::class, 'FormGetFileDokumentasi'])->name('ajax.scd.apps.form.get.file.dok');
        });
    });
});

// NOC
Route::get('/noc/{name}', [NocController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
 */
Route::group(['middleware' => ['pbh', 'auth', 'LastSeen']], function () {
    // base-apps
    Route::get('/dashboard', [BaseAppsController::class, 'index'])->name('auth.home');

    // AUTH
    Route::group(['prefix' => 'auth'], function () {
        Route::get('/logout', [LoginController::class, 'logout'])->name('prt.lgn.logout');
    });

    /*
    |--------------------------------------------------------------------------
    | PORTAL APPS
    | PATH : WebBase/WebAdmin/PortalApps
    |--------------------------------------------------------------------------
     */
    Route::group(['prefix' => 'portal-apps'], function () {
        // middleware : AdminPortal
        Route::group(['middleware' => ['AdminPortal']], function () {
            // dashboard
            Route::get('/', [PADashboardController::class, 'index'])->name('prt.apps.home.index');
            // auth
            // PATH : WebBase/WebAdmin/auth
            Route::group(['prefix' => 'auth'], function () {
                Route::get('/profile', [PAProfileController::class, 'index'])->name('prt.apps.auth.profile.index');
                Route::put('/profile', [PAProfileController::class, 'update'])->name('prt.apps.auth.profile.update');
            });
            // master
            Route::group(['prefix' => 'master'], function () {
                // portal kategori
                Route::group(['prefix' => 'kategori'], function () {
                    Route::get('/', [PAKategoriController::class, 'index'])->name('prt.apps.mst.tags.index');
                    Route::get('/create', [PAKategoriController::class, 'create'])->name('prt.apps.mst.tags.create');
                    Route::post('/create', [PAKategoriController::class, 'store'])->name('prt.apps.mst.tags.store');
                    Route::get('/edit/{uuid}', [PAKategoriController::class, 'edit'])->name('prt.apps.mst.tags.edit');
                    Route::put('/edit/{uuid}', [PAKategoriController::class, 'update'])->name('prt.apps.mst.tags.update');
                    Route::post('/status', [PAKategoriController::class, 'status'])->name('prt.apps.mst.tags.status');
                    Route::post('/delete', [PAKategoriController::class, 'destroy'])->name('prt.apps.mst.tags.destroy');
                });
                // portal sosmed
                Route::group(['prefix' => 'sosmed'], function () {
                    Route::get('/', [PASosmedController::class, 'index'])->name('prt.apps.mst.sosmed.index');
                    Route::put('/', [PASosmedController::class, 'update'])->name('prt.apps.mst.sosmed.update');
                });
                // portal setup
                Route::group(['prefix' => 'setup'], function () {
                    Route::get('/', [PASetupController::class, 'index'])->name('prt.apps.mst.setup.index');
                    Route::put('/', [PASetupController::class, 'update'])->name('prt.apps.mst.setup.update');
                });
            });
            // portal postingan
            Route::group(['prefix' => 'postingan'], function () {
                Route::get('/', [PAPostinganController::class, 'index'])->name('prt.apps.post.index');
                Route::get('/create', [PAPostinganController::class, 'create'])->name('prt.apps.post.create');
                Route::post('/create', [PAPostinganController::class, 'store'])->name('prt.apps.post.store');
                Route::get('/edit/{uuid}', [PAPostinganController::class, 'edit'])->name('prt.apps.post.edit');
                Route::put('/edit/{uuid}', [PAPostinganController::class, 'update'])->name('prt.apps.post.update');
                Route::post('/delete', [PAPostinganController::class, 'destroy'])->name('prt.apps.post.destroy');
            });
            // portal halaman
            Route::group(['prefix' => 'halaman'], function () {
                Route::get('/', [PAHalamanController::class, 'index'])->name('prt.apps.page.index');
                Route::get('/create', [PAHalamanController::class, 'create'])->name('prt.apps.page.create');
                Route::post('/create', [PAHalamanController::class, 'store'])->name('prt.apps.page.store');
                Route::get('/edit/{uuid}', [PAHalamanController::class, 'edit'])->name('prt.apps.page.edit');
                Route::put('/edit/{uuid}', [PAHalamanController::class, 'update'])->name('prt.apps.page.update');
                Route::post('/delete', [PAHalamanController::class, 'destroy'])->name('prt.apps.page.destroy');
            });
            // portal banner
            Route::group(['prefix' => 'banner'], function () {
                Route::get('/', [PABannerController::class, 'index'])->name('prt.apps.banner.index');
                Route::get('/create', [PABannerController::class, 'create'])->name('prt.apps.banner.create');
                Route::post('/create', [PABannerController::class, 'store'])->name('prt.apps.banner.store');
                Route::get('/edit/{uuid}', [PABannerController::class, 'edit'])->name('prt.apps.banner.edit');
                Route::put('/edit/{uuid}', [PABannerController::class, 'update'])->name('prt.apps.banner.update');
                Route::post('/delete', [PABannerController::class, 'destroy'])->name('prt.apps.banner.destroy');
            });
            // portal galeri
            Route::group(['prefix' => 'galeri'], function () {
                Route::get('/', [PAGaleriController::class, 'index'])->name('prt.apps.gallery.index');
                Route::get('/create', [PAGaleriController::class, 'create'])->name('prt.apps.gallery.create');
                Route::post('/create', [PAGaleriController::class, 'store'])->name('prt.apps.gallery.store');
                Route::get('/edit/{uuid}', [PAGaleriController::class, 'edit'])->name('prt.apps.gallery.edit');
                Route::put('/edit/{uuid}', [PAGaleriController::class, 'update'])->name('prt.apps.gallery.update');
                Route::post('/delete', [PAGaleriController::class, 'destroy'])->name('prt.apps.gallery.destroy');
                // portal foto galeri
                Route::group(['prefix' => '{uuid}/foto'], function () {
                    Route::get('/', [PAFotoController::class, 'index'])->name('prt.apps.foto.index');
                    Route::post('/upload', [PAFotoController::class, 'upload'])->name('prt.apps.foto.upload');
                    Route::post('/delete', [PAFotoController::class, 'destroy'])->name('prt.apps.foto.destroy');
                });
            });
            // portal video
            Route::group(['prefix' => 'video'], function () {
                Route::get('/', [PAVideoController::class, 'index'])->name('prt.apps.video.index');
                Route::get('/create', [PAVideoController::class, 'create'])->name('prt.apps.video.create');
                Route::post('/create', [PAVideoController::class, 'store'])->name('prt.apps.video.store');
                Route::get('/edit/{uuid}', [PAVideoController::class, 'edit'])->name('prt.apps.video.edit');
                Route::put('/edit/{uuid}', [PAVideoController::class, 'update'])->name('prt.apps.video.update');
                Route::post('/delete', [PAVideoController::class, 'destroy'])->name('prt.apps.video.destroy');
            });
            // portal unduhan
            Route::group(['prefix' => 'unduhan'], function () {
                Route::get('/', [PAUnduhanController::class, 'index'])->name('prt.apps.unduh.index');
                Route::get('/create', [PAUnduhanController::class, 'create'])->name('prt.apps.unduh.create');
                Route::post('/create', [PAUnduhanController::class, 'store'])->name('prt.apps.unduh.store');
                Route::get('/edit/{uuid}', [PAUnduhanController::class, 'edit'])->name('prt.apps.unduh.edit');
                Route::put('/edit/{uuid}', [PAUnduhanController::class, 'update'])->name('prt.apps.unduh.update');
                Route::post('/delete', [PAUnduhanController::class, 'destroy'])->name('prt.apps.unduh.destroy');
            });
            // portal pesan
            Route::group(['prefix' => 'pesan'], function () {
                Route::get('/', [PAPesanController::class, 'index'])->name('prt.apps.pesan.index');
                Route::get('/read/{uuid}', [PAPesanController::class, 'read'])->name('prt.apps.pesan.read');
                Route::post('/delete', [PAPesanController::class, 'destroy'])->name('prt.apps.pesan.destroy');
            });
            // portal faq
            Route::group(['prefix' => 'faq'], function () {
                Route::get('/', [PAFAQController::class, 'index'])->name('prt.apps.faq.index');
                Route::get('/create', [PAFAQController::class, 'create'])->name('prt.apps.faq.create');
                Route::post('/create', [PAFAQController::class, 'store'])->name('prt.apps.faq.store');
                Route::get('/edit/{uuid}', [PAFAQController::class, 'edit'])->name('prt.apps.faq.edit');
                Route::put('/edit/{uuid}', [PAFAQController::class, 'update'])->name('prt.apps.faq.update');
                Route::post('/delete', [PAFAQController::class, 'destroy'])->name('prt.apps.faq.destroy');
            });
            // portal faq
            Route::group(['prefix' => 'statistik'], function () {
                Route::get('/', [PAStatistikController::class, 'index'])->name('prt.apps.stat.index');
            });
        });
    });

    /*
    |--------------------------------------------------------------------------
    | PENJADWALAN DAN PENUGASAN APPS - PERUSAHAAN (PdpApps)
    | PATH : WebBase/WebAdmin/PdpApps
    |--------------------------------------------------------------------------
     */
    Route::group(['prefix' => 'pdp-apps'], function () {
        // middleware : Perusahaan
        Route::group(['middleware' => ['Perusahaan']], function () {
            // dashboard
            Route::get('/', [PDPDashboardController::class, 'index'])->name('pdp.apps.home.index');

            // auth
            // PATH : WebBase/WebAdmin/auth
            Route::group(['prefix' => 'auth'], function () {
                Route::get('/profile', [PDPProfileController::class, 'index'])->name('pdp.apps.auth.profile.index');
                Route::post('/profile', [PDPProfileController::class, 'update'])->name('pdp.apps.auth.profile.update');
                Route::post('/default-alamat', [PDPProfileController::class, 'defaultAlamat'])->name('pdp.apps.auth.alamat.default');
                Route::get('/alamat/{uuid}', [PDPProfileController::class, 'showAlamat'])->name('pdp.apps.auth.alamat.show');
                Route::delete('/alamat', [PDPProfileController::class, 'destroy'])->name('pdp.apps.auth.alamat.destroy');
            });

            // permohonan
            Route::group(['prefix' => 'permohonan'], function () {
                Route::get('/', [PDPPermohonanPeneraanController::class, 'index'])->name('pdp.apps.reqpeneraan.index');
                Route::get('/create', [PDPPermohonanPeneraanController::class, 'create'])->name('pdp.apps.reqpeneraan.create');
                Route::post('/create', [PDPPermohonanPeneraanController::class, 'store'])->name('pdp.apps.reqpeneraan.store');
                Route::get('/edit/{uuid}', [PDPPermohonanPeneraanController::class, 'edit'])->name('pdp.apps.reqpeneraan.edit');
                Route::put('/edit/{uuid}', [PDPPermohonanPeneraanController::class, 'update'])->name('pdp.apps.reqpeneraan.update');
                Route::get('/show/{uuid}', [PDPPermohonanPeneraanController::class, 'show'])->name('pdp.apps.reqpeneraan.show');
                Route::delete('/delete', [PDPPermohonanPeneraanController::class, 'destroy'])->name('pdp.apps.reqpeneraan.destroy');
                Route::get('/data', [PDPPermohonanPeneraanController::class, 'data'])->name('pdp.apps.reqpeneraan.data');
            });

            // sertifikat
            Route::group(['prefix' => 'sertifikat'], function () {
                Route::get('/', [PDPSertifikatSKHPController::class, 'index'])->name('pdp.apps.sertifikat.skhp.index');
            });

            // middleware : ProtectFiturRetribusi
            Route::group(['middleware' => ['ProtectFiturRetribusi']], function () {
                // retribusi
                Route::group(['prefix' => 'retribusi'], function () {
                    Route::get('/', [PDPRetribusiController::class, 'index'])->name('pdp.apps.retribusi.index');
                    Route::get('/create/{uuid}', [PDPRetribusiController::class, 'create'])->name('pdp.apps.retribusi.create');
                    Route::post('/create/{uuid}', [PDPRetribusiController::class, 'store'])->name('pdp.apps.retribusi.store');
                });
            });

            // sertifikat
            Route::group(['prefix' => 'sertifikat'], function () {
                Route::get('/', [PDPSertifikatSKHPController::class, 'index'])->name('pdp.apps.sertifikat.skhp.index');
            });
        });
    });

    /*
    |--------------------------------------------------------------------------
    | PENJADWALAN DAN PENUGASAN APPS - ADMIN (ScheduleApps)
    | PATH : WebBase/WebAdmin/ScheduleApps
    |--------------------------------------------------------------------------
     */
    Route::group(['prefix' => 'schedule-apps'], function () {
        // middleware : Pegawai
        Route::group(['middleware' => ['Pegawai']], function () {
            // dashboard
            Route::get('/', [ScdDashboardController::class, 'index'])->name('scd.apps.home.index');
            // middleware : KetuaTimDanPimpinan
            Route::group(['middleware' => ['KetuaTimDanPimpinan']], function () {
                // permohonan
                // PATH : WebBase/WebAdmin/ScheduleApps/permohonan
                Route::group(['prefix' => 'permohonan/{tags}'], function () {
                    Route::get('/', [ScdPermohonanPengujianController::class, 'index'])->name('scd.apps.pp.index');
                    // middleware : Verifikator
                    Route::group(['middleware' => ['Verifikator']], function () {
                        Route::put('/status', [ScdPermohonanPengujianController::class, 'status'])->name('scd.apps.pp.status');
                        Route::put('/pindah-jp', [ScdPermohonanPengujianController::class, 'pindahJP'])->name('scd.apps.pp.pindahjp');
                    });
                    Route::get('/data', [ScdPermohonanPengujianController::class, 'data'])->name('scd.apps.pp.data');
                });
            });
            // middleware : KetuaTimPelayanan
            Route::group(['middleware' => ['KetuaTimPelayanan']], function () {
                // input-data
                // PATH : WebBase/WebAdmin/ScheduleApps/permohonan
                Route::group(['prefix' => 'input-data'], function () {
                    Route::get('/', [ScdInputDataPdpController::class, 'index'])->name('scd.apps.input.pdp.index');
                    Route::get('/create/{uuid}', [ScdInputDataPdpController::class, 'create'])->name('scd.apps.input.pdp.create');
                    Route::post('/create/{uuid}', [ScdInputDataPdpController::class, 'store'])->name('scd.apps.input.pdp.store');
                    Route::put('/update/{uuid}', [ScdInputDataPdpController::class, 'update'])->name('scd.apps.input.pdp.update');
                    Route::get('/data', [ScdInputDataPdpController::class, 'data'])->name('scd.apps.input.pdp.data');
                });
            });
            // jadwal-penugasan
            // PATH : WebBase/WebAdmin/ScheduleApps/penera
            Route::group(['prefix' => 'jadwal-penugasan'], function () {
                Route::get('/', [ScdDataPdpController::class, 'index'])->name('scd.apps.data.pdp.index');
                Route::get('/show/{uuid}', [ScdDataPdpController::class, 'show'])->name('scd.apps.data.pdp.show');
                // middleware : KetuaTimPelayanan
                Route::group(['middleware' => ['KetuaTimPelayanan']], function () {
                    Route::get('/edit/{uuid}', [ScdDataPdpController::class, 'edit'])->name('scd.apps.data.pdp.edit');
                    Route::put('/edit/{uuid}', [ScdDataPdpController::class, 'update'])->name('scd.apps.data.pdp.update');
                });
                // middleware : PetugasOnly
                Route::group(['middleware' => ['PetugasOnly']], function () {
                    Route::put('/status', [ScdDataPdpController::class, 'status'])->name('scd.apps.data.pdp.status');
                });
                Route::get('/data', [ScdDataPdpController::class, 'data'])->name('scd.apps.data.pdp.data');
            });
            // instrumen-alat
            // PATH : WebBase/WebAdmin/ScheduleApps/penera
            Route::group(['prefix' => 'instrumen-alat'], function () {
                Route::get('/', [ScdInstrumenAlatController::class, 'index'])->name('scd.apps.insalat.index');
                Route::get('/show/{uuid}', [ScdInstrumenAlatController::class, 'show'])->name('scd.apps.insalat.show');
                // middleware : PetugasOnly
                Route::group(['middleware' => ['PetugasOnly']], function () {
                    Route::get('/edit/{uuid}', [ScdInstrumenAlatController::class, 'edit'])->name('scd.apps.insalat.edit');
                    Route::put('/edit/{uuid}', [ScdInstrumenAlatController::class, 'update'])->name('scd.apps.insalat.update');
                });
                Route::get('/data', [ScdInstrumenAlatController::class, 'data'])->name('scd.apps.insalat.data');
            });
            // tindak-lanjut
            // PATH : WebBase/WebAdmin/ScheduleApps/tinjut
            Route::group(['prefix' => 'tindak-lanjut'], function () {
                // massa
                Route::group(['prefix' => 'mt'], function () {
                    Route::get('/', [ScdTinjutMTController::class, 'index'])->name('scd.apps.tinjut.mt.index');
                    Route::get('/data', [ScdTinjutMTController::class, 'data'])->name('scd.apps.tinjut.mt.data');
                });
                // uapv
                Route::group(['prefix' => 'uapv'], function () {
                    Route::get('/', [ScdTinjutUapvController::class, 'index'])->name('scd.apps.tinjut.uapv.index');
                    Route::get('/data', [ScdTinjutUapvController::class, 'data'])->name('scd.apps.tinjut.uapv.data');
                });
                // bdkt
                Route::group(['prefix' => 'bdkt'], function () {
                    Route::get('/', [ScdTinjutBdktController::class, 'index'])->name('scd.apps.tinjut.bdkt.index');
                    Route::get('/data', [ScdTinjutBdktController::class, 'data'])->name('scd.apps.tinjut.bdkt.data');
                });
                // action
                Route::group(['prefix' => 'action/{tags_jp}'], function () {
                    // manajemen-cerapan
                    // PATH : WebBase/WebAdmin/ScheduleApps/tinjut/action
                    Route::group(['prefix' => 'manajemen-cerapan'], function () {
                        Route::get('/{uuid}', [ScdTinjutActionCerapanController::class, 'index'])->name('scd.apps.tinjut.action.cerapan.index');
                    });
                    // manajemen-ba
                    // PATH : WebBase/WebAdmin/ScheduleApps/tinjut/action
                    Route::group(['prefix' => 'manajemen-ba'], function () {
                        Route::get('/{uuid}', [ScdTinjutActionBaController::class, 'index'])->name('scd.apps.tinjut.action.ba.index');
                    });
                    // manajemen-dokumentasi
                    // PATH : WebBase/WebAdmin/ScheduleApps/tinjut/action
                    Route::group(['prefix' => 'manajemen-dokumentasi'], function () {
                        Route::get('/{uuid}', [ScdTinjutActionDokumentasiController::class, 'index'])->name('scd.apps.tinjut.action.dok.index');
                    });

                    // middleware : Admin
                    Route::group(['middleware' => ['Admin']], function () {
                        // manajemen-skhp
                        // PATH : WebBase/WebAdmin/ScheduleApps/tinjut/action
                        Route::group(['prefix' => 'manajemen-skhp'], function () {
                            Route::get('/{uuid}', [ScdTinjutActionSkhpController::class, 'index'])->name('scd.apps.tinjut.action.skhp.index');
                            Route::post('/{uuid}/generate-tte', [ScdTinjutActionSkhpController::class, 'store'])->name('scd.apps.tinjut.action.skhp.store');
                            Route::get('/{uuid}/download-tte/{kode_tte}', [ScdTinjutActionSkhpController::class, 'downloadTte'])->name('scd.apps.tinjut.action.skhp.unduh');
                            Route::delete('/{uuid}/hapus-tte', [ScdTinjutActionSkhpController::class, 'destroy'])->name('scd.apps.tinjut.action.skhp.destroy');
                        });
                        // manajemen-retribusi
                        // PATH : WebBase/WebAdmin/ScheduleApps/tinjut/action
                        Route::group(['prefix' => 'manajemen-retribusi'], function () {
                            Route::get('/{uuid}', [ScdTinjutActionRetribusiController::class, 'index'])->name('scd.apps.tinjut.action.retribusi.index');
                            Route::put('/{uuid}/generate-skrd', [ScdTinjutActionRetribusiController::class, 'generateSkrd'])->name('scd.apps.tinjut.action.retribusi.generate');
                            Route::get('/{uuid}/download-kode-bayar/{kode_bayar_webr}', [ScdTinjutActionRetribusiController::class, 'downloadKodeBayar'])->name('scd.apps.tinjut.action.retribusi.unduhkode');
                        });
                    });

                    // middleware : PetugasOnly
                    Route::group(['middleware' => ['PetugasOnly']], function () {
                        // manajemen-cerapan
                        // PATH : WebBase/WebAdmin/ScheduleApps/tinjut/action
                        Route::group(['prefix' => 'manajemen-cerapan'], function () {
                            Route::post('/{uuid}', [ScdTinjutActionCerapanController::class, 'store'])->name('scd.apps.tinjut.action.cerapan.store');
                            Route::delete('/{uuid}/delete', [ScdTinjutActionCerapanController::class, 'destroy'])->name('scd.apps.tinjut.action.cerapan.destroy');
                        });
                        // manajemen-ba
                        // PATH : WebBase/WebAdmin/ScheduleApps/tinjut/action
                        Route::group(['prefix' => 'manajemen-ba'], function () {
                            Route::post('/{uuid}', [ScdTinjutActionBaController::class, 'store'])->name('scd.apps.tinjut.action.ba.store');
                            Route::delete('/{uuid}/delete', [ScdTinjutActionBaController::class, 'destroy'])->name('scd.apps.tinjut.action.ba.destroy');
                        });
                        // manajemen-dokumentasi
                        // PATH : WebBase/WebAdmin/ScheduleApps/tinjut/action
                        Route::group(['prefix' => 'manajemen-dokumentasi'], function () {
                            Route::post('/{uuid}', [ScdTinjutActionDokumentasiController::class, 'store'])->name('scd.apps.tinjut.action.dok.store');
                            Route::delete('/{uuid}/delete', [ScdTinjutActionDokumentasiController::class, 'destroy'])->name('scd.apps.tinjut.action.dok.destroy');
                        });
                    });
                });
            });
            // middleware : PejabatTte
            Route::group(['middleware' => ['PejabatTte']], function () {
                // tte-skhp
                // PATH : WebBase/WebAdmin/ScheduleApps/tte
                Route::group(['prefix' => 'tte-skhp'], function () {
                    Route::get('/', [ScdTteSkhpController::class, 'index'])->name('scd.apps.tte.skhp.index');
                    Route::put('/status', [ScdTteSkhpController::class, 'status'])->name('scd.apps.tte.skhp.status');
                    Route::get('/data', [ScdTteSkhpController::class, 'data'])->name('scd.apps.tte.skhp.data');
                });
            });
        });
    });

    /*
    |--------------------------------------------------------------------------
    | PENGAWASAN APPS - ADMIN (SupervisionApps)
    | PATH : WebBase/WebAdmin/SupervisionApps
    |--------------------------------------------------------------------------
     */
    Route::group(['prefix' => 'supervision-apps'], function () {
        // middleware : Pegawai
        Route::group(['middleware' => ['Pegawai']], function () {
            // dashboard
            Route::get('/', [SpvDashboardController::class, 'index'])->name('spv.apps.home.index');
            // potensi-peneraan
            // PATH : WebBase/WebAdmin/SupervisionApps/pp
            Route::group(['prefix' => 'pemantauan'], function () {
                // pemantauan
                Route::group(['prefix' => 'pemantauan'], function () {
                    Route::get('/', [SpvPPPemantauanController::class, 'index'])->name('spv.apps.pp.pemantauan.index');
                    Route::get('/data', [SpvPPPemantauanController::class, 'data'])->name('spv.apps.pp.pemantauan.data');
                });
            });

            // middleware : KetuaTimPengawasan
            Route::group(['middleware' => ['KetuaTimPengawasan']], function () {
            });

            /*
            |--------------------------------------------------------------------------
            | ROUTE YANG AKAN DIHAPUS
            |--------------------------------------------------------------------------
             */
            // middleware : KetuaTimDanPimpinan
            Route::group(['middleware' => ['KetuaTimDanPimpinan']], function () {
                // permohonan
                // PATH : WebBase/WebAdmin/SupervisionApps/permohonan
                // Route::group(['prefix' => 'permohonan/{tags}'], function () {
                //     Route::get('/', [ScdPermohonanPengujianController::class, 'index'])->name('spv.apps.pp.index');
                //     // middleware : Verifikator
                //     Route::group(['middleware' => ['Verifikator']], function () {
                //         Route::put('/status', [ScdPermohonanPengujianController::class, 'status'])->name('spv.apps.pp.status');
                //         Route::put('/pindah-jp', [ScdPermohonanPengujianController::class, 'pindahJP'])->name('spv.apps.pp.pindahjp');
                //     });
                //     Route::get('/data', [ScdPermohonanPengujianController::class, 'data'])->name('spv.apps.pp.data');
                // });
            });
            // middleware : KetuaTimDanPimpinan
            Route::group(['middleware' => ['KetuaTimDanPimpinan']], function () {
                // permohonan
                // PATH : WebBase/WebAdmin/SupervisionApps/permohonan
                // Route::group(['prefix' => 'permohonan/{tags}'], function () {
                //     Route::get('/', [ScdPermohonanPengujianController::class, 'index'])->name('spv.apps.pp.index');
                //     // middleware : Verifikator
                //     Route::group(['middleware' => ['Verifikator']], function () {
                //         Route::put('/status', [ScdPermohonanPengujianController::class, 'status'])->name('spv.apps.pp.status');
                //         Route::put('/pindah-jp', [ScdPermohonanPengujianController::class, 'pindahJP'])->name('spv.apps.pp.pindahjp');
                //     });
                //     Route::get('/data', [ScdPermohonanPengujianController::class, 'data'])->name('spv.apps.pp.data');
                // });
            });
            // middleware : KetuaTimPelayanan
            Route::group(['middleware' => ['KetuaTimPelayanan']], function () {
                // input-data
                // PATH : WebBase/WebAdmin/SupervisionApps/permohonan
                Route::group(['prefix' => 'input-data'], function () {
                    Route::get('/', [ScdInputDataPdpController::class, 'index'])->name('spv.apps.input.pdp.index');
                    Route::get('/create/{uuid}', [ScdInputDataPdpController::class, 'create'])->name('spv.apps.input.pdp.create');
                    Route::post('/create/{uuid}', [ScdInputDataPdpController::class, 'store'])->name('spv.apps.input.pdp.store');
                    Route::put('/update/{uuid}', [ScdInputDataPdpController::class, 'update'])->name('spv.apps.input.pdp.update');
                    Route::get('/data', [ScdInputDataPdpController::class, 'data'])->name('spv.apps.input.pdp.data');
                });
            });
            // jadwal-penugasan
            // PATH : WebBase/WebAdmin/SupervisionApps/penera
            Route::group(['prefix' => 'jadwal-penugasan'], function () {
                Route::get('/', [ScdDataPdpController::class, 'index'])->name('spv.apps.data.pdp.index');
                Route::get('/show/{uuid}', [ScdDataPdpController::class, 'show'])->name('spv.apps.data.pdp.show');
                // middleware : KetuaTimPelayanan
                Route::group(['middleware' => ['KetuaTimPelayanan']], function () {
                    Route::get('/edit/{uuid}', [ScdDataPdpController::class, 'edit'])->name('spv.apps.data.pdp.edit');
                    Route::put('/edit/{uuid}', [ScdDataPdpController::class, 'update'])->name('spv.apps.data.pdp.update');
                });
                // middleware : PetugasOnly
                Route::group(['middleware' => ['PetugasOnly']], function () {
                    Route::put('/status', [ScdDataPdpController::class, 'status'])->name('spv.apps.data.pdp.status');
                });
                Route::get('/data', [ScdDataPdpController::class, 'data'])->name('spv.apps.data.pdp.data');
            });
            // instrumen-alat
            // PATH : WebBase/WebAdmin/SupervisionApps/penera
            Route::group(['prefix' => 'instrumen-alat'], function () {
                Route::get('/', [ScdInstrumenAlatController::class, 'index'])->name('spv.apps.insalat.index');
                Route::get('/show/{uuid}', [ScdInstrumenAlatController::class, 'show'])->name('spv.apps.insalat.show');
                // middleware : PetugasOnly
                Route::group(['middleware' => ['PetugasOnly']], function () {
                    Route::get('/edit/{uuid}', [ScdInstrumenAlatController::class, 'edit'])->name('spv.apps.insalat.edit');
                    Route::put('/edit/{uuid}', [ScdInstrumenAlatController::class, 'update'])->name('spv.apps.insalat.update');
                });
                Route::get('/data', [ScdInstrumenAlatController::class, 'data'])->name('spv.apps.insalat.data');
            });
            // tindak-lanjut
            // PATH : WebBase/WebAdmin/SupervisionApps/tinjut
            Route::group(['prefix' => 'tindak-lanjut'], function () {
                // massa
                Route::group(['prefix' => 'mt'], function () {
                    Route::get('/', [ScdTinjutMTController::class, 'index'])->name('spv.apps.tinjut.mt.index');
                    Route::get('/data', [ScdTinjutMTController::class, 'data'])->name('spv.apps.tinjut.mt.data');
                });
                // uapv
                Route::group(['prefix' => 'uapv'], function () {
                    Route::get('/', [ScdTinjutUapvController::class, 'index'])->name('spv.apps.tinjut.uapv.index');
                    Route::get('/data', [ScdTinjutUapvController::class, 'data'])->name('spv.apps.tinjut.uapv.data');
                });
                // bdkt
                Route::group(['prefix' => 'bdkt'], function () {
                    Route::get('/', [ScdTinjutBdktController::class, 'index'])->name('spv.apps.tinjut.bdkt.index');
                    Route::get('/data', [ScdTinjutBdktController::class, 'data'])->name('spv.apps.tinjut.bdkt.data');
                });
            });
        });
    });

    /*
    |--------------------------------------------------------------------------
    | PENGATURAN APPS
    | PATH : WebBase/WebAdmin/SettingsApps
    |--------------------------------------------------------------------------
     */
    Route::group(['prefix' => 'settings-apps'], function () {
        // middleware : Pegawai
        Route::group(['middleware' => ['Pegawai']], function () {
            // dashboard
            Route::get('/', [SetAppsDashboardController::class, 'index'])->name('set.apps.home.index');

            // auth
            // PATH : WebBase/WebAdmin/auth
            Route::group(['prefix' => 'profile'], function () {
                Route::get('/', [SetAppsProfileController::class, 'index'])->name('set.apps.profile.index');
                Route::put('/', [SetAppsProfileController::class, 'update'])->name('set.apps.profile.update');
            });

            // master
            // PATH : WebBase/WebAdmin/SettingsApps/master
            Route::group(['prefix' => 'master'], function () {
                // middleware : AdminSystem
                Route::group(['middleware' => ['AdminSystem']], function () {
                    // super-admin
                    Route::group(['prefix' => 'super-admin'], function () {
                        Route::get('/', [SetAppsSuperAdminController::class, 'index'])->name('set.apps.mst.sa.index');
                        Route::post('/create', [SetAppsSuperAdminController::class, 'store'])->name('set.apps.mst.sa.store');
                        Route::get('/edit/{uuid}', [SetAppsSuperAdminController::class, 'edit'])->name('set.apps.mst.sa.edit');
                        Route::put('/edit/{uuid}', [SetAppsSuperAdminController::class, 'update'])->name('set.apps.mst.sa.update');
                        Route::put('/status', [SetAppsSuperAdminController::class, 'status'])->name('set.apps.mst.sa.status');
                        Route::delete('/delete', [SetAppsSuperAdminController::class, 'destroy'])->name('set.apps.mst.sa.destroy');
                        Route::get('/data', [SetAppsSuperAdminController::class, 'data'])->name('set.apps.mst.sa.data');
                    });
                });

                // PATH : WebBase/WebAdmin/SettingsApps/master/uttp
                // instrumen-uttp
                Route::group(['prefix' => 'instrumen-uttp'], function () {
                    // jenis-uttp
                    Route::group(['prefix' => 'jenis-uttp'], function () {
                        Route::get('/', [SetAppsInsUttpJenisController::class, 'index'])->name('set.apps.mst.ins.uttp.jenis.index');
                        // middleware : Admin
                        Route::group(['middleware' => ['Admin']], function () {
                            Route::post('/create', [SetAppsInsUttpJenisController::class, 'store'])->name('set.apps.mst.ins.uttp.jenis.store');
                            Route::get('/edit/{uuid}', [SetAppsInsUttpJenisController::class, 'edit'])->name('set.apps.mst.ins.uttp.jenis.edit');
                            Route::put('/edit/{uuid}', [SetAppsInsUttpJenisController::class, 'update'])->name('set.apps.mst.ins.uttp.jenis.update');
                            Route::put('/status', [SetAppsInsUttpJenisController::class, 'status'])->name('set.apps.mst.ins.uttp.jenis.status');
                            Route::delete('/delete', [SetAppsInsUttpJenisController::class, 'destroy'])->name('set.apps.mst.ins.uttp.jenis.destroy');
                        });
                        Route::get('/data', [SetAppsInsUttpJenisController::class, 'data'])->name('set.apps.mst.ins.uttp.jenis.data');
                        Route::get('/show/{uuid}', [SetAppsInsUttpJenisController::class, 'show'])->name('set.apps.mst.ins.uttp.jenis.show');
                    });
                    // daftar-item-uttp
                    Route::group(['prefix' => 'daftar-item-uttp'], function () {
                        Route::get('/', [SetAppsInsUttpDaftarItemController::class, 'index'])->name('set.apps.mst.ins.uttp.item.index');
                        // middleware : Admin
                        Route::group(['middleware' => ['Admin']], function () {
                            Route::post('/create', [SetAppsInsUttpDaftarItemController::class, 'store'])->name('set.apps.mst.ins.uttp.item.store');
                            Route::get('/edit/{uuid}', [SetAppsInsUttpDaftarItemController::class, 'edit'])->name('set.apps.mst.ins.uttp.item.edit');
                            Route::put('/edit/{uuid}', [SetAppsInsUttpDaftarItemController::class, 'update'])->name('set.apps.mst.ins.uttp.item.update');
                            Route::put('/status', [SetAppsInsUttpDaftarItemController::class, 'status'])->name('set.apps.mst.ins.uttp.item.status');
                            Route::delete('/delete', [SetAppsInsUttpDaftarItemController::class, 'destroy'])->name('set.apps.mst.ins.uttp.item.destroy');
                        });
                        Route::get('/data', [SetAppsInsUttpDaftarItemController::class, 'data'])->name('set.apps.mst.ins.uttp.item.data');
                        Route::get('/show/{uuid}', [SetAppsInsUttpDaftarItemController::class, 'show'])->name('set.apps.mst.ins.uttp.item.show');
                    });
                });

                // PATH : WebBase/WebAdmin/SettingsApps/master/uttp
                // jenis-uttp
                Route::group(['prefix' => 'jenis-uttp'], function () {
                    // jenis-pelayanan
                    Route::group(['prefix' => 'jenis-pelayanan'], function () {
                        Route::get('/', [SetAppsUttpJenisPelayananController::class, 'index'])->name('set.apps.mst.uttp.jp.index');
                        // middleware : Admin
                        Route::group(['middleware' => ['Admin']], function () {
                            Route::post('/create', [SetAppsUttpJenisPelayananController::class, 'store'])->name('set.apps.mst.uttp.jp.store');
                            Route::get('/edit/{uuid}', [SetAppsUttpJenisPelayananController::class, 'edit'])->name('set.apps.mst.uttp.jp.edit');
                            Route::put('/edit/{uuid}', [SetAppsUttpJenisPelayananController::class, 'update'])->name('set.apps.mst.uttp.jp.update');
                            Route::put('/status', [SetAppsUttpJenisPelayananController::class, 'status'])->name('set.apps.mst.uttp.jp.status');
                            Route::delete('/delete', [SetAppsUttpJenisPelayananController::class, 'destroy'])->name('set.apps.mst.uttp.jp.destroy');
                        });
                        Route::get('/data', [SetAppsUttpJenisPelayananController::class, 'data'])->name('set.apps.mst.uttp.jp.data');
                        Route::get('/show/{uuid}', [SetAppsUttpJenisPelayananController::class, 'show'])->name('set.apps.mst.uttp.jp.show');
                    });
                    // kelompok-uttp
                    Route::group(['prefix' => 'kelompok-uttp'], function () {
                        Route::get('/', [SetAppsUttpKelompokController::class, 'index'])->name('set.apps.mst.uttp.klpk.index');
                        // middleware : Admin
                        Route::group(['middleware' => ['Admin']], function () {
                            Route::post('/create', [SetAppsUttpKelompokController::class, 'store'])->name('set.apps.mst.uttp.klpk.store');
                            Route::get('/edit/{uuid}', [SetAppsUttpKelompokController::class, 'edit'])->name('set.apps.mst.uttp.klpk.edit');
                            Route::put('/edit/{uuid}', [SetAppsUttpKelompokController::class, 'update'])->name('set.apps.mst.uttp.klpk.update');
                            Route::put('/status', [SetAppsUttpKelompokController::class, 'status'])->name('set.apps.mst.uttp.klpk.status');
                            Route::delete('/delete', [SetAppsUttpKelompokController::class, 'destroy'])->name('set.apps.mst.uttp.klpk.destroy');
                        });
                        Route::get('/data', [SetAppsUttpKelompokController::class, 'data'])->name('set.apps.mst.uttp.klpk.data');
                        Route::get('/show/{uuid}', [SetAppsUttpKelompokController::class, 'show'])->name('set.apps.mst.uttp.klpk.show');
                    });
                    // kategori-kelompok
                    Route::group(['prefix' => 'kategori-kelompok'], function () {
                        Route::get('/', [SetAppsUttpTagsKelompokController::class, 'index'])->name('set.apps.mst.uttp.tags.klpk.index');
                        // middleware : Admin
                        Route::group(['middleware' => ['Admin']], function () {
                            Route::post('/create', [SetAppsUttpTagsKelompokController::class, 'store'])->name('set.apps.mst.uttp.tags.klpk.store');
                            Route::get('/edit/{uuid}', [SetAppsUttpTagsKelompokController::class, 'edit'])->name('set.apps.mst.uttp.tags.klpk.edit');
                            Route::put('/edit/{uuid}', [SetAppsUttpTagsKelompokController::class, 'update'])->name('set.apps.mst.uttp.tags.klpk.update');
                            Route::put('/status', [SetAppsUttpTagsKelompokController::class, 'status'])->name('set.apps.mst.uttp.tags.klpk.status');
                            Route::delete('/delete', [SetAppsUttpTagsKelompokController::class, 'destroy'])->name('set.apps.mst.uttp.tags.klpk.destroy');
                        });
                        Route::get('/data', [SetAppsUttpTagsKelompokController::class, 'data'])->name('set.apps.mst.uttp.tags.klpk.data');
                        Route::get('/show/{uuid}', [SetAppsUttpTagsKelompokController::class, 'show'])->name('set.apps.mst.uttp.tags.klpk.show');
                    });
                });

                // PATH : WebBase/WebAdmin/SettingsApps/master
                // fitur
                Route::group(['prefix' => 'fitur'], function () {
                    Route::get('/', [SetAppsFiturController::class, 'index'])->name('set.apps.mst.fitur.index');
                    // middleware : Admin
                    Route::group(['middleware' => ['Admin']], function () {
                        Route::put('/status', [SetAppsFiturController::class, 'status'])->name('set.apps.mst.fitur.status');
                    });
                    Route::get('/data', [SetAppsFiturController::class, 'data'])->name('set.apps.mst.fitur.data');
                });
            });

            // perusahaan
            Route::group(['prefix' => 'perusahaan'], function () {
                Route::get('/{tags}', [SetAppsPerusahaanController::class, 'index'])->name('set.apps.perusahaan.index');
                // middleware : Verifikator
                Route::group(['middleware' => ['Verifikator']], function () {
                    Route::post('/{tags}/create', [SetAppsPerusahaanController::class, 'store'])->name('set.apps.perusahaan.store');
                    Route::post('/{tags}/status-aktifkan', [SetAppsPerusahaanController::class, 'statusAktifkan'])->name('set.apps.perusahaan.status.aktifkan');
                    Route::post('/{tags}/status-tangguhkan', [SetAppsPerusahaanController::class, 'statusTangguhkan'])->name('set.apps.perusahaan.status.tangguhkan');
                    Route::get('/{tags}/edit/{uuid}', [SetAppsPerusahaanController::class, 'edit'])->name('set.apps.perusahaan.edit');
                    Route::put('/{tags}/edit/{uuid}', [SetAppsPerusahaanController::class, 'update'])->name('set.apps.perusahaan.update');
                    Route::delete('/{tags}/delete', [SetAppsPerusahaanController::class, 'destroy'])->name('set.apps.perusahaan.destroy');
                    Route::post('/{tags}/default-alamat', [SetAppsPerusahaanController::class, 'defaultAlamat'])->name('set.apps.perusahaan.alamat.default');
                    Route::delete('/{tags}/delete-alamat', [SetAppsPerusahaanController::class, 'destroyAlamat'])->name('set.apps.perusahaan.alamat.destroy');
                });
                Route::get('/{tags}/show/{uuid}', [SetAppsPerusahaanController::class, 'show'])->name('set.apps.perusahaan.show');
                Route::get('/{tags}/data', [SetAppsPerusahaanController::class, 'data'])->name('set.apps.perusahaan.data');
                Route::get('/{tags}/show-alamat/{uuid}', [SetAppsPerusahaanController::class, 'showAlamat'])->name('set.apps.perusahaan.alamat.show');
            });

            // pegawai
            Route::group(['prefix' => 'pegawai'], function () {
                Route::get('/', [SetAppsPegawaiController::class, 'index'])->name('set.apps.pegawai.index');
                // middleware : SuperAdmin
                Route::group(['middleware' => ['SuperAdmin']], function () {
                    Route::post('/create', [SetAppsPegawaiController::class, 'store'])->name('set.apps.pegawai.store');
                    Route::get('/edit/{uuid}', [SetAppsPegawaiController::class, 'edit'])->name('set.apps.pegawai.edit');
                    Route::put('/edit/{uuid}', [SetAppsPegawaiController::class, 'update'])->name('set.apps.pegawai.update');
                    Route::put('/status', [SetAppsPegawaiController::class, 'status'])->name('set.apps.pegawai.status');
                    Route::delete('/delete', [SetAppsPegawaiController::class, 'destroy'])->name('set.apps.pegawai.destroy');
                });
                Route::get('/show/{uuid}', [SetAppsPegawaiController::class, 'show'])->name('set.apps.pegawai.show');
                Route::get('/data', [SetAppsPegawaiController::class, 'data'])->name('set.apps.pegawai.data');
            });

            // kepala-bidang
            Route::group(['prefix' => 'kepala-bidang'], function () {
                Route::get('/', [SetAppsKabidController::class, 'index'])->name('set.apps.kabid.index');
                // middleware : SuperAdmin
                Route::group(['middleware' => ['SuperAdmin']], function () {
                    Route::post('/create', [SetAppsKabidController::class, 'store'])->name('set.apps.kabid.store');
                    Route::get('/edit/{uuid}', [SetAppsKabidController::class, 'edit'])->name('set.apps.kabid.edit');
                    Route::put('/edit/{uuid}', [SetAppsKabidController::class, 'update'])->name('set.apps.kabid.update');
                    Route::put('/status', [SetAppsKabidController::class, 'status'])->name('set.apps.kabid.status');
                    Route::delete('/delete', [SetAppsKabidController::class, 'destroy'])->name('set.apps.kabid.destroy');
                });
                Route::get('/show/{uuid}', [SetAppsKabidController::class, 'show'])->name('set.apps.kabid.show');
                Route::get('/data', [SetAppsKabidController::class, 'data'])->name('set.apps.kabid.data');
            });

            // kepala-dinas
            Route::group(['prefix' => 'kepala-dinas'], function () {
                Route::get('/', [SetAppsKadisController::class, 'index'])->name('set.apps.kadis.index');
                // middleware : SuperAdmin
                Route::group(['middleware' => ['SuperAdmin']], function () {
                    Route::post('/create', [SetAppsKadisController::class, 'store'])->name('set.apps.kadis.store');
                    Route::get('/edit/{uuid}', [SetAppsKadisController::class, 'edit'])->name('set.apps.kadis.edit');
                    Route::put('/edit/{uuid}', [SetAppsKadisController::class, 'update'])->name('set.apps.kadis.update');
                    Route::put('/status', [SetAppsKadisController::class, 'status'])->name('set.apps.kadis.status');
                    Route::delete('/delete', [SetAppsKadisController::class, 'destroy'])->name('set.apps.kadis.destroy');
                });
                Route::get('/show/{uuid}', [SetAppsKadisController::class, 'show'])->name('set.apps.kadis.show');
                Route::get('/data', [SetAppsKadisController::class, 'data'])->name('set.apps.kadis.data');
            });
        });
    });
});
