<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SantriController;
use App\Http\Controllers\Api\SakitController;
use App\Http\Controllers\Api\ObatController;
use App\Http\Controllers\Api\LaporanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// =========================================
// PUBLIC ROUTES (No Authentication)
// =========================================
Route::post('/login', [AuthController::class, 'login']);

// =========================================
// PROTECTED ROUTES (Require Sanctum Token)
// =========================================
Route::middleware('auth:sanctum')->group(function () {
    
    // ==================
    // AUTH
    // ==================
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/user', [AuthController::class, 'updateProfile']);
    Route::put('/user/password', [AuthController::class, 'changePassword']);

    // ==================
    // SANTRI
    // ==================
    Route::prefix('santri')->group(function () {
        Route::get('/', [SantriController::class, 'index']);
        Route::get('/search', [SantriController::class, 'search']);
        Route::get('/{id}', [SantriController::class, 'show']);
    });

    // ==================
    // SAKIT (Health Records)
    // ==================
    Route::prefix('sakit')->group(function () {
        Route::get('/', [SakitController::class, 'index']);
        Route::post('/', [SakitController::class, 'store']);
        Route::get('/{id}', [SakitController::class, 'show']);
        Route::put('/{id}', [SakitController::class, 'update']);
        Route::delete('/{id}', [SakitController::class, 'destroy']);
        Route::put('/{id}/sembuh', [SakitController::class, 'markRecovered']);
    });

    // ==================
    // OBAT (Medicines)
    // ==================
    Route::prefix('obats')->group(function () {
        Route::get('/', [ObatController::class, 'index']);
        Route::post('/', [ObatController::class, 'store']);
        Route::get('/expiring', [ObatController::class, 'expiring']);
        Route::get('/low-stock', [ObatController::class, 'lowStock']);
        Route::get('/{id}', [ObatController::class, 'show']);
        Route::put('/{id}', [ObatController::class, 'update']);
        Route::delete('/{id}', [ObatController::class, 'destroy']);
        Route::post('/{id}/restock', [ObatController::class, 'restock']);
    });

    // ==================
    // LAPORAN (Reports)
    // ==================
    Route::prefix('laporan')->group(function () {
        Route::get('/summary', [LaporanController::class, 'summary']);
        Route::get('/detail', [LaporanController::class, 'detail']);
        Route::get('/monthly', [LaporanController::class, 'monthly']);
        Route::get('/download', [LaporanController::class, 'download']);
    });
});

