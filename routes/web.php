<?php

use App\Http\Controllers\ManajemenAlumniController;
use App\Http\Controllers\ProfesiController;
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

Route::get('/', function () {
    return view('layoutAdmin.dashboard');
});
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', function () {
        return view('layoutAdmin.dashboard');
    });
    Route::get('/profesi', [ProfesiController::class, 'index']);
    Route::post('/listProfesi', [ProfesiController::class, 'list']);
    Route::get('/create_ajax', [ProfesiController::class, 'create_ajax']);
    Route::post('/profesi/store', [ProfesiController::class, 'store']);
    Route::get('/{id}/edit_ajax', [ProfesiController::class, 'edit_ajax']); //menampilkan halaman form edit Level ajax
    Route::put('/{id}/update_ajax', [ProfesiController::class, 'update_ajax']); //menyimpan perubahan data Level ajax
    Route::get('/{id}/delete_ajax', [ProfesiController::class, 'confirm_ajax']);
    Route::delete('/profesi/{id}/delete_ajax', [ProfesiController::class, 'delete_ajax']);

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
});
