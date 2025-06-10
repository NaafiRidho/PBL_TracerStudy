<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManajemenAlumniController;
use App\Http\Controllers\ProfesiController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\Auth\OtpLoginController as AuthOtpLoginController; // Using alias for clarity if needed
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SurveiController;
// If JawabanSurveiController is used for storing answers, ensure it's imported
// use App\Http\Controllers\JawabanSurveiController; // Uncomment if you intend to use this controller directly for answers
use Illuminate\Support\Facades\Route;
// Removed duplicate 'use Illuminate\Support\Facades\Route;'
// Removed duplicate 'use App\Http\Controllers\ManajemenAlumniController;'
// Removed 'use App\Http\Controllers\OtpLoginController;' if it's the same as AuthOtpLoginController
// Removed 'use App\Http\Controllers\PenggunaLulusanController;' if not actively used here
// Removed 'use App\Models\PertanyaanModel;' as models are typically used directly in controllers, not routes


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

// --- Public Routes / Authentication ---
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login'); // Main login page
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// OTP Login Routes
Route::get('/login/email', [AuthOtpLoginController::class, 'showEmailForm'])->name('otp.email.form');
Route::post('/login/email', [AuthOtpLoginController::class, 'sendOtp'])->name('otp.send');
Route::get('/login/otp', [AuthOtpLoginController::class, 'showOtpForm'])->name('otp.verify.form');
Route::post('/login/otp', [AuthOtpLoginController::class, 'verifyOtp'])->name('otp.verify');

// Publicly accessible survey question retrieval (assuming this doesn't require login)
Route::get('/survei', [SurveiController::class, 'getPertanyaan']);
Route::post('/jawaban', [SurveiController::class, 'store']); // Endpoint to store survey answers

// --- Alumni Routes (Authenticated) ---
Route::middleware(['auth:alumni', 'cek.alumni.login'])->group(function () {
    Route::get('/dashboard', function () { // Example dashboard for alumni
        return view('dashboard');
    })->name('dashboard');

    Route::get('/alumni/{id}', [AlumniController::class, 'index'])->name('alumni.form');
    Route::get('/alumni/list/{id}', [AlumniController::class, 'list']);
    Route::put('/alumni/update/{id}', [AlumniController::class, 'update']);
    Route::get('/profesi/by-kategori/{kategori_profesi_id}', [AlumniController::class, 'byKategori']); // Moved here as it seems related to alumni profiles

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- Atasan/Supervisor Survey Routes (Authenticated) ---
Route::middleware(['auth:atasan', 'cek.atasan.login'])->group(function () {
    Route::get('/atasan/survei/{id}', [SurveiController::class, 'create'])->name('kuisioner');
    // If JawabanSurveiController is specifically for atasan, use it here:
    // Route::post('/atasan/jawaban', [JawabanSurveiController::class, 'store']);
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| These are routes for the admin panel, grouped with the prefix "admin".
| Add 'auth' and 'role:admin' middleware if necessary.
|
*/
Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth', 'role:Admin'] // Add this if only admins can access
], function () {

    // === Dashboard Admin ===
    Route::get('/', function () { // Corresponds to /admin
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

    // === PROFESI Management ===
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

    // === ALUMNI Management ===
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

    // === PERTANYAAN Management ===
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

    // === Export Reports ===
    Route::get('/alumni-belum-mengisi', [ExportController::class, 'showAlumniBelumMengisi'])->name('admin.alumni-belum');
    Route::get('/rekap/export/excel', [ExportController::class, 'exportExcel'])->name('admin.export.excel');

    Route::get('/alumni-sudah-mengisi', [ExportController::class, 'showAlumni'])->name('admin.alumni-sudah');
    Route::get('/rekap/export/alumni-sudah', [ExportController::class, 'exportExcelLulusan'])->name('rekap.export.sudah');

    Route::get('/atasan/belum-mengisi', [ExportController::class, 'showAtasanBelumMengisi']);
    Route::get('/atasan/export/excel', [ExportController::class, 'exportExcelAtasanBelumMengisi']);

    Route::get('/atasan-sudah-mengisi', [ExportController::class, 'showAtasan'])->name('atasan.sudahMengisi');
    Route::get('/atasan/export/excel/sudah', [ExportController::class, 'exportExcelPenggunaSudahMengisi']);
});

// Require Auth routes
require __DIR__ . '/auth.php';