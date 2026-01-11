<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ManagementController;
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

    // Core Data
    Route::apiResource('santri', SantriController::class);
    Route::apiResource('obat', ObatController::class);

    // Transactions (Sakit)
    Route::get('sakit', [SakitController::class, 'index']);
    Route::get('sakit/{id}', [SakitController::class, 'show']);
    Route::post('sakit', [SakitController::class, 'store']);
    Route::post('sakit/{id}/sembuh', [SakitController::class, 'markSembuh']);
    Route::delete('sakit/{id}', [SakitController::class, 'destroy']);

    // Reports & Statistics
    Route::get('/laporan/summary', [LaporanController::class, 'getSummary']);
    Route::get('/laporan/statistics', [LaporanController::class, 'getStatistics']);
    Route::get('/dashboard', [LaporanController::class, 'getSummary']); // Alias for mobile dashboard

    // Activity Logs
    Route::get('/logs', [ActivityLogController::class, 'index']);
    Route::post('/logs', [ActivityLogController::class, 'store']);
    Route::get('/history', [ActivityLogController::class, 'index']); // Alias for mobile history

    // Management (Kelas, Jurusan, Diagnosis) - Generic Endpoints
    Route::get('/management/{type}', [ManagementController::class, 'index']);
    Route::get('/management/{type}/all', [ManagementController::class, 'all']);
    Route::post('/management/{type}', [ManagementController::class, 'store']);
    Route::delete('/management/{type}/{id}', [ManagementController::class, 'destroy']);
    
    // Global Search
    Route::get('/search', [ManagementController::class, 'search']);

    // Admin & User Management
    Route::get('/admin/registrations', [AdminController::class, 'getPendingRequests']);
    Route::post('/admin/registrations/{id}/approve', [AdminController::class, 'approveRequest']);
    Route::post('/admin/registrations/{id}/reject', [AdminController::class, 'rejectRequest']);
    
    Route::get('/users', [AdminController::class, 'getUsers']);
    Route::post('/users/{id}/toggle-admin', [AdminController::class, 'toggleAdmin']);
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);
});
