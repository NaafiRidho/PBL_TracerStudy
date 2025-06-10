<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\Auth\OtpLoginController as AuthOtpLoginController;
use App\Http\Controllers\OtpLoginController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\ManajemenAlumniController;
use App\Http\Controllers\ProfesiController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\PenggunaLulusanController;
use App\Http\Controllers\SurveiController;
use App\Http\Controllers\JawabanSurveiController;
use App\Models\PertanyaanModel;

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
    return view('layoutLandingPage.hero'); // Digabung view dari 'atasan'
});

// ======== Alumni (Autentikasi OTP & Dashboard) =========
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/login/email', [AuthOtpLoginController::class, 'showEmailForm'])->name('otp.email.form');
Route::post('/login/email', [AuthOtpLoginController::class, 'sendOtp'])->name('otp.send');
Route::get('/login/otp', [AuthOtpLoginController::class, 'showOtpForm'])->name('otp.verify.form');
Route::post('/login/otp', [AuthOtpLoginController::class, 'verifyOtp'])->name('otp.verify');
Route::get('/profesi/by-kategori/{kategori_profesi_id}', [AlumniController::class, 'byKategori']);
Route::get('/survei', [SurveiController::class, 'getPertanyaan']);
Route::post('/jawaban', [SurveiController::class, 'store']);

Route::middleware(['auth:alumni', 'cek.alumni.login'])->group(function () {
    Route::get('/alumni/{id}', [AlumniController::class, 'index'])->name('alumni.form');
    Route::get('/alumni/list/{id}', [AlumniController::class, 'list']);
    Route::put('/alumni/update/{id}', [AlumniController::class, 'update']);
});

// ======== Survei Atasan =========
Route::middleware(['auth:atasan', 'cek.atasan.login'])->group(function () {
    Route::get('/atasan/survei/{id}', [SurveiController::class, 'create'])->name('kuisioner');
    // Route::post('/jawaban', [JawabanSurveiController::class, 'store']);
});
