<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BalitaController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\DataUjiController;
use App\Http\Controllers\SertifikatController;
use App\Http\Controllers\JadwalImunisasiController;
use App\Http\Controllers\PegawaiPosyanduController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\RiwayatImunisasiController;
use App\Http\Controllers\SettingPuskesmasController;

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

Route::get('/', [HomeController::class ,'index'])->name('home');
Route::get('/validate-user', [DashboardController::class, 'validate'])->middleware(['auth', 'verified'])->name('validate');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth', 'verified', 'role:Admin'])->name('dashboard');
Route::get('/dashboard/orang-tua', [DashboardController::class, 'dashboardPengguna'])->middleware(['auth', 'verified', 'role:Pengguna'])->name('dashboard.pengguna');
Route::get('/petunjuk/informasi', [DashboardController::class, 'petunjuk'])->middleware(['auth', 'verified',])->name('petunjuk');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


Route::middleware(['auth', 'verified', 'role:Admin|Pengguna'])->group(function () {


    // Route Master
    Route::group(['prefix' => 'Master', 'as' => "Master."], function () {
        Route::controller(MasterController::class)->group(function () {
            Route::get('/', 'index')->name('index');
        });
    });
    // Route Kriteria
    Route::group(['prefix' => 'Kriteria', 'as' => "Kriteria."], function () {
        Route::controller(KriteriaController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tambah-kriteria', 'create')->name('create');
            Route::get('/ubah-kriteria', 'edit')->name('edit');
            Route::get('/detail-kriteria', 'show')->name('show');
            Route::post('/store-kriteria', 'store')->name('store');
            Route::put('/update-kriteria', 'update')->name('update');
            Route::delete('/destroy-kriteria', 'destroy')->name('destroy');
        });
    });
    // Route Alternatif
    Route::group(['prefix' => 'Alternatif', 'as' => "Alternatif."], function () {
        Route::controller(AlternatifController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tambah-alternatif', 'create')->name('create');
            Route::get('/ubah-alternatif', 'edit')->name('edit');
            Route::get('/detail-alternatif', 'show')->name('show');
            Route::post('/store-alternatif', 'store')->name('store');
            Route::post('/store-alternatif', 'storeForm')->name('store.form');
            Route::put('/update-alternatif', 'update')->name('update');
            Route::delete('/destroy-alternatif', 'destroy')->name('destroy');
        });
    });
    Route::group(['prefix' => 'Topsis', 'as' => "Topsis."], function () {
        Route::controller(PenilaianController::class)->group(function () {
            Route::get('/hasil', 'index')->name('index');
            Route::get('/rekomendasi', 'indexUser')->name('index.user');
        });
    });

    Route::group(['prefix' => 'Datauji', 'as' => "Datauji."], function () {
        Route::controller(DataUjiController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tambah-data-penilaian', 'create')->name('create');
            Route::get('/ubah-data-penilaian', 'edit')->name('edit');
            Route::get('/detail-data-penilaian', 'show')->name('show');
            Route::post('/store-data-penilaian', 'store')->name('store');
            Route::put('/update-data-penilaian', 'update')->name('update');
            Route::delete('/destroy-data-penilaian', 'destroy')->name('destroy');
        });
    });
});


Route::get('pdf-document', [PDFController::class, 'generatePDF'])->name('pdf');
