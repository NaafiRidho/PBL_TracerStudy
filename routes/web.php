<?php

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
});
