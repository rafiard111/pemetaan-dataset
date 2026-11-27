
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DatasetController;
use App\Http\Controllers\PemetaanController;
use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\PenggunaanDatasetController;

/*
|--------------------------------------------------------------------------
| AUTENTIKASI
|--------------------------------------------------------------------------
*/

// Halaman login hanya untuk pengguna yang belum login.
Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.process');

});

// Logout hanya bisa dilakukan setelah login.
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| HALAMAN INTERNAL - WAJIB LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | HALAMAN UTAMA
    |--------------------------------------------------------------------------
    */

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | DATASET
    |--------------------------------------------------------------------------
    */

    Route::get('/dataset', [DatasetController::class, 'index'])
        ->name('dataset.index');

    Route::post('/dataset/import', [DatasetController::class, 'import'])
        ->name('dataset.import');

    Route::post('/dataset/classify', [DatasetController::class, 'classify'])
        ->name('dataset.classify');

    Route::get('/dataset/belum-terklasifikasi', [DatasetController::class, 'belumTerklasifikasi'])
        ->name('dataset.belum-terklasifikasi');


    /*
    |--------------------------------------------------------------------------
    | PEMETAAN DATA
    |--------------------------------------------------------------------------
    */

    Route::get('/pemetaan', [PemetaanController::class, 'index'])
        ->name('pemetaan.index');


    /*
    |--------------------------------------------------------------------------
    | ANALISIS DATA
    |--------------------------------------------------------------------------
    */

    Route::get('/analisis', [AnalisisController::class, 'index'])
        ->name('analisis.index');


    /*
    |--------------------------------------------------------------------------
    | ANALISIS KETERKAITAN DATASET ANTAR-OPD
    |--------------------------------------------------------------------------
    */

    Route::get('/analisis/penggunaan-dataset', [PenggunaanDatasetController::class, 'index'])
        ->name('analisis.penggunaan-dataset');


    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD HASIL ANALISIS
    |--------------------------------------------------------------------------
    */

    Route::get('/analisis/export', [AnalisisController::class, 'export'])
        ->name('analisis.export');

});
