<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManajemenAlumniController;
use App\Http\Controllers\ProfesiController;
use App\Http\Controllers\PertanyaanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Ini adalah route untuk halaman admin yang dikelompokkan dengan prefix "admin".
| Bisa ditambahkan middleware 'auth' dan 'role:admin' jika perlu.
|
*/

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth', 'role:Admin'] // Tambahkan ini jika hanya admin boleh akses
], function () {

    // === Dashboard Admin ===
    Route::get('/', function () {
        return view('layoutAdmin.index');
    });
    Route::get('/dashboard/instansi-chart', [DashboardController::class, 'getInstansiChartData']);
    Route::get('/dashboard/profesi-chart', [DashboardController::class, 'getProfesiChart']);
    Route::get('/dashboard/rekap-alumni', [DashboardController::class, 'getRekapAlumni']);
    Route::get('/dashboard/average-waiting-time', [DashboardController::class, 'getAverageWaitingTime']);
    Route::get('/dashboard/alumni-satisfaction', [DashboardController::class, 'getAlumniSatisfaction']);
    Route::get('/dashboard/kerjasama-chart', [DashboardController::class, 'getKerjaSama']);
    Route::get('/dashboard/keahlian-chart', [DashboardController::class, 'keahlianChart']);
    Route::get('/dashboard/kemampuan-bahasa-chart', [DashboardController::class, 'kemampuanBahasaChart']);
    Route::get('/dashboard/kemampuan-komunikasi-chart', [DashboardController::class, 'kemampuanKomunikasiChart']);
    Route::get('/dashboard/pengembangan-diri-chart', [DashboardController::class, 'pengembanganDiriChart']);
    Route::get('/dashboard/kepemimpinan-chart', [DashboardController::class, 'kepemimpinanChart']);
    Route::get('/dashboard/etos-kerja-chart', [DashboardController::class, 'etosKerjaChart']);

    // === PROFESI ===
    Route::prefix('profesi')->group(function () {
        Route::get('/', [ProfesiController::class, 'index']);
        Route::post('/listprofesi', [ProfesiController::class, 'list']);
        Route::get('/create_ajax', [ProfesiController::class, 'create_ajax']);
        Route::post('/store', [ProfesiController::class, 'store']);
        Route::get('/{id}/edit_ajax', [ProfesiController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [ProfesiController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [ProfesiController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [ProfesiController::class, 'delete_ajax']);
    });

    // === MANAJEMEN ALUMNI ===
    Route::prefix('alumni')->group(function () {
        Route::get('/', function () {
            return view('layoutAdmin.manajemenAlumni.alumni');
        });
        Route::post('/listalumni', [ManajemenAlumniController::class, 'list']);
        Route::get('/import_ajax', [ManajemenAlumniController::class, 'import']);
        Route::post('/import_ajax', [ManajemenAlumniController::class, 'import_ajax']);
        Route::get('/create_ajax', [ManajemenAlumniController::class, 'create_ajax']);
        Route::post('/store', [ManajemenAlumniController::class, 'store']);
        Route::get('/{id}/edit_ajax', [ManajemenAlumniController::class, 'edit']);
        Route::put('/update/{id}', [ManajemenAlumniController::class, 'update']);
        Route::get('/{id}/delete_ajax', [ManajemenAlumniController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [ManajemenAlumniController::class, 'delete_ajax']);
    });

    // === PERTANYAAN ===
    Route::prefix('pertanyaan')->group(function () {
        Route::get('/', [PertanyaanController::class, 'index']);
        Route::get('/list', [PertanyaanController::class, 'list']);
        Route::get('/create_ajax', [PertanyaanController::class, 'create_ajax']);
        Route::post('/store', [PertanyaanController::class, 'store']);
        Route::get('/{id}/edit_ajax', [PertanyaanController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [PertanyaanController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [PertanyaanController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [PertanyaanController::class, 'delete_ajax']);
    });
});
