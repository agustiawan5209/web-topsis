<?php

use App\Http\Controllers\BalitaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalImunisasiController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PegawaiPosyanduController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatImunisasiController;
use App\Http\Controllers\SertifikatController;
use App\Http\Controllers\SettingPuskesmasController;
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

Route::get('/', [HomeController::class ,'index'])->name('home');
Route::get('/validate-user', [DashboardController::class, 'validate'])->middleware(['auth', 'verified'])->name('validate');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth', 'verified', 'role:Admin'])->name('dashboard');
Route::get('/dashboard/orang-tua', [DashboardController::class, 'dashboardPengguna'])->middleware(['auth', 'verified', 'role:Pengguna'])->name('dashboard.pengguna');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


Route::middleware(['auth', 'verified', 'role:Admin|Pengguna'])->group(function () {


    // Route Setting Puskesma
    Route::group(['prefix' => 'Master', 'as' => "Master."], function () {
        Route::controller(MasterController::class)->group(function () {
            Route::get('/', 'index')->name('index');
        });
    });
});


Route::get('pdf-document', [PDFController::class, 'generatePDF'])->name('pdf');
