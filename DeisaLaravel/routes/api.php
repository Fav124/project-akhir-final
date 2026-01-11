<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MasterDataController;
use App\Http\Controllers\Api\SantriController;
use App\Http\Controllers\Api\ObatController;
use App\Http\Controllers\Api\SakitController;
use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\Api\ActivityLogController;
use App\Http\Controllers\Api\AdminController;

// Public Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Master Data
    Route::get('/jurusans', [MasterDataController::class, 'getJurusan']);
    Route::post('/jurusans', [MasterDataController::class, 'storeJurusan']);
    Route::delete('/jurusans/{id}', [MasterDataController::class, 'destroyJurusan']);
    
    Route::get('/kelas', [MasterDataController::class, 'getKelas']);
    Route::post('/kelas', [MasterDataController::class, 'storeKelas']);
    Route::delete('/kelas/{id}', [MasterDataController::class, 'destroyKelas']);
    
    Route::get('/diagnosis', [MasterDataController::class, 'getDiagnosis']);
    Route::post('/diagnosis', [MasterDataController::class, 'storeDiagnosis']);
    Route::delete('/diagnosis/{id}', [MasterDataController::class, 'destroyDiagnosis']);

    // Core Data
    Route::apiResource('santri', SantriController::class);
    Route::apiResource('obat', ObatController::class);

    // Transactions
    Route::get('sakit', [SakitController::class, 'index']);
    Route::post('sakit', [SakitController::class, 'store']);
    Route::post('sakit/{id}/sembuh', [SakitController::class, 'markSembuh']);

    // Reports & Statistics
    Route::get('/laporan/summary', [LaporanController::class, 'getSummary']);
    Route::get('/laporan/statistics', [LaporanController::class, 'getStatistics']);

    // Activity Logs
    Route::get('/logs', [ActivityLogController::class, 'index']);
    Route::post('/logs', [ActivityLogController::class, 'store']);

    // Admin & User Management
    Route::get('/admin/registrations', [AdminController::class, 'getPendingRequests']);
    Route::post('/admin/registrations/{id}/approve', [AdminController::class, 'approveRequest']);
    Route::post('/admin/registrations/{id}/reject', [AdminController::class, 'rejectRequest']);
    Route::get('/admin/users', [AdminController::class, 'getUsers']);
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser']);
});
