<?php

use App\Http\Controllers\WebBase\WebAdmin\auth\LoginController;
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
Route::get('/', [HomeController::class, 'index'])->name('prt.home.index');
Route::group(['prefix' => 'portal'], function () {
    // post
    Route::get('/post/{tags}', [PostController::class, 'index'])->name('prt.post.index');
    Route::get('/post/{tags}/{slug}', [PostController::class, 'readPost'])->name('prt.post.read');
    // static-page
    Route::get('/page/{slug}', [PostController::class, 'staticPage'])->name('prt.page.index');
    // search
    Route::get('/search', [PostController::class, 'searchPost'])->name('prt.q.index');
    // media
    Route::get('/media/{tags}', [MediaController::class, 'index'])->name('prt.media.index');
    Route::get('/media/{tags}/{slug}', [MediaController::class, 'readMedia'])->name('prt.media.read');
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

// NOC
Route::get('/noc/{name}', [NocController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
 */
Route::group(['middleware' => ['pbh', 'auth']], function () {
    //
});
