<?php

use App\Http\Controllers\WebBase\WebAdmin\auth\LoginController;
use App\Http\Controllers\WebBase\WebAdmin\auth\PAProfileController;
use App\Http\Controllers\WebBase\WebAdmin\configs\BaseAppsController;
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
use App\Http\Controllers\WebBase\WebConfigs\ExDownController;
use App\Http\Controllers\WebBase\WebConfigs\NocController;
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
            Route::get('/login', [LoginController::class, 'index'])->name('prt.lgn.index');
            Route::post('/login', [LoginController::class, 'store'])->name('prt.lgn.post');
            // Route::get('/reset', [ResetController::class, 'index'])->name('prt.rst.index');
            // Route::post('/reset', [ResetController::class, 'store'])->name('prt.rst.post');
            // Route::get('/reset/{uuid}', [ResetController::class, 'edit'])->name('prt.rst.edit');
            // Route::put('/reset/{uuid}', [ResetController::class, 'update'])->name('prt.rst.update');
        });
    });

    // exdown | Export - Download
    Route::group(['prefix' => 'exdown'], function () {
        // unduhan
        Route::get('/unduhan/{uuid}', [ExDownController::class, 'unduhan'])->name('exdown.unduh');
    });
});
// NOC
Route::get('/noc/{name}', [NocController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
 */
Route::group(['middleware' => ['pbh', 'auth']], function () {
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
