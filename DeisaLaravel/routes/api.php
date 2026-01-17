<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

// Auth API
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);

// Android API Endpoints (v1)
Route::prefix('v1')->group(function () {
  Route::get('/obat', [App\Http\Controllers\Api\ObatController::class, 'index']);
  Route::get('/obat/{id}', [App\Http\Controllers\Api\ObatController::class, 'show']);
  Route::post('/obat', [App\Http\Controllers\Api\ObatController::class, 'store']);
  Route::put('/obat/{id}', [App\Http\Controllers\Api\ObatController::class, 'update']);
  Route::delete('/obat/{id}', [App\Http\Controllers\Api\ObatController::class, 'destroy']);
  Route::post('/obat/{id}/use', [App\Http\Controllers\Api\ObatController::class, 'use']);
});

Route::middleware('auth:sanctum')->group(function () {
  Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);

  // Santri
  Route::get('santri', [App\Http\Controllers\Api\SantriController::class, 'index']);
  Route::get('santri/{id}', [App\Http\Controllers\Api\SantriController::class, 'show']);
  Route::post('santri', [App\Http\Controllers\Api\SantriController::class, 'store']);
  Route::put('santri/{id}', [App\Http\Controllers\Api\SantriController::class, 'update']);
  Route::delete('santri/{id}', [App\Http\Controllers\Api\SantriController::class, 'destroy']);

  // Sakit
  Route::get('sakit', [App\Http\Controllers\Api\SakitController::class, 'index']);
  Route::get('sakit/{id}', [App\Http\Controllers\Api\SakitController::class, 'show']);
  Route::post('sakit', [App\Http\Controllers\Api\SakitController::class, 'store']);
  Route::put('sakit/{id}', [App\Http\Controllers\Api\SakitController::class, 'update']);
  Route::delete('sakit/{id}', [App\Http\Controllers\Api\SakitController::class, 'destroy']);
  Route::post('sakit/{id}/sembuh', [App\Http\Controllers\Api\SakitController::class, 'markSembuh']);
  Route::get('santri-sakit/today', [App\Http\Controllers\Api\SakitController::class, 'today']);

  // Management
  Route::prefix('management')->group(function () {
    Route::get('users', [App\Http\Controllers\Api\AdminController::class, 'getUsers']);
    Route::delete('users/{id}', [App\Http\Controllers\Api\AdminController::class, 'deleteUser']);
    Route::get('pending-registrations', [App\Http\Controllers\Api\AdminController::class, 'getPendingRegistrations']);
    Route::post('approve/{id}', [App\Http\Controllers\Api\AdminController::class, 'approveRegistration']);
    Route::post('reject/{id}', [App\Http\Controllers\Api\AdminController::class, 'rejectRegistration']);

    Route::get('kelas', [App\Http\Controllers\Api\ManagementController::class, 'getKelas']);
    Route::post('kelas', [App\Http\Controllers\Api\ManagementController::class, 'addKelas']);
    Route::delete('kelas/{id}', [App\Http\Controllers\Api\ManagementController::class, 'deleteKelas']);

    Route::get('jurusan', [App\Http\Controllers\Api\ManagementController::class, 'getJurusan']);
    Route::post('jurusan', [App\Http\Controllers\Api\ManagementController::class, 'addJurusan']);
    Route::delete('jurusan/{id}', [App\Http\Controllers\Api\ManagementController::class, 'deleteJurusan']);

    Route::get('diagnosis', [App\Http\Controllers\Api\ManagementController::class, 'getDiagnosis']);
    Route::post('diagnosis', [App\Http\Controllers\Api\ManagementController::class, 'addDiagnosis']);
    Route::delete('diagnosis/{id}', [App\Http\Controllers\Api\ManagementController::class, 'deleteDiagnosis']);

    Route::get('history', [App\Http\Controllers\Api\ActivityLogController::class, 'index']);
  });

  // Laporan
  Route::get('laporan/summary', [App\Http\Controllers\Api\LaporanController::class, 'getSummary']);
  Route::get('reports/cases-trend', [App\Http\Controllers\Api\LaporanController::class, 'getStatistics']);
});
