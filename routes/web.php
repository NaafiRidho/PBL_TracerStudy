<?php

use App\Http\Controllers\ManajemenAlumniController;
use App\Http\Controllers\ProfesiController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\PenggunaLulusanController;
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
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', function () {
        return view('layoutAdmin.pertanyaan.index');
    });

    // === Profesi ===
    Route::get('/profesi', [ProfesiController::class, 'index']);
    Route::post('/profesi/listprofesi', [ProfesiController::class, 'list']);
    Route::get('/profesi/create_ajax', [ProfesiController::class, 'create_ajax']);
    Route::post('/profesi/store', [ProfesiController::class, 'store']);
    Route::get('/profesi/{id}/edit_ajax', [ProfesiController::class, 'edit_ajax']);
    Route::put('/profesi/{id}/update_ajax', [ProfesiController::class, 'update_ajax']);
    Route::get('/profesi/{id}/delete_ajax', [ProfesiController::class, 'confirm_ajax']);
    Route::delete('/profesi/{id}/delete_ajax', [ProfesiController::class, 'delete_ajax']);

    // === Manajemen Alumni ===
    Route::get('/alumni', function () {
        return view('layoutAdmin.manajemenAlumni.alumni');
    });
    Route::post('/listalumni', [ManajemenAlumniController::class, 'list']);
    Route::get('/alumni/import_ajax', [ManajemenAlumniController::class, 'import']);
    Route::post('/alumni/import_ajax', [ManajemenAlumniController::class, 'import_ajax']);
    Route::get('/alumni/create_ajax', [ManajemenAlumniController::class, 'create_ajax']);
    Route::post('/alumni/store', [ManajemenAlumniController::class, 'store']);
    Route::get('/alumni/{id}/edit_ajax', [ManajemenAlumniController::class, 'edit']);
    Route::put('/alumni/update/{id}', [ManajemenAlumniController::class, 'update']);
    Route::get('/alumni/{id}/delete_ajax', [ManajemenAlumniController::class, 'confirm_ajax']);
    Route::delete('/alumni/{id}/delete_ajax', [ManajemenAlumniController::class, 'delete_ajax']);

    // === Pertanyaan ===
    Route::get('/pertanyaan', [PertanyaanController::class, 'index']);
    Route::get('/pertanyaan/list', [PertanyaanController::class, 'list']);
    Route::get('/pertanyaan/create_ajax', [PertanyaanController::class, 'create_ajax']);
    Route::post('/pertanyaan/store', [PertanyaanController::class, 'store']);
    Route::get('/pertanyaan/{id}/edit_ajax', [PertanyaanController::class, 'edit_ajax']);
    Route::put('/pertanyaan/{id}/update_ajax', [PertanyaanController::class, 'update_ajax']);
    Route::get('/pertanyaan/{id}/delete_ajax', [PertanyaanController::class, 'confirm_ajax']);
    Route::delete('/pertanyaan/{id}/delete_ajax', [PertanyaanController::class, 'delete_ajax']);
});

Route::group(['prefix' => 'penggunaLulusan'], function () {
    Route::get('/', [PenggunaLulusanController::class, 'index']);
    Route::post('/store', [PenggunaLulusanController::class, 'store']);
});

Route::get('/', function () {
    return view('layoutLandingPage.hero');
});