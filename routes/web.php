<?php

use App\Http\Controllers\CsrfCookieController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public dio aplikacije - web site
Route::get('/', [HomeController::class, 'index']);
Route::get('/page', [HomeController::class, 'page']);

// Ovdje vracamo generusanu SPA index stranicu
Route::get('/login', [HomeController::class, 'login']);

// Routes for SPA API calls
Route::prefix('spa')->group(function () {

    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout']);
    Route::get('csrf-cookie', [CsrfCookieController::class, 'show']);
    // Route::get('locale/{locale}', [HomeController::class, 'setLocale']);

    /**
     * Stranice dozvoljene za pristup samo autorizovanim korisnicima
     */
    Route::group(['middleware' => 'auth'], function () {
        Route::get('check', [HomeController::class, 'check']);

        require __DIR__.'/spa.php';
    });
});

// Na produkciji moramo odgovoriti na refresh + /assets, tj. povesti korisnika na spa login page
Route::any('/{any}', [HomeController::class, 'login'])->where('any', '^(?!spa).*$');
