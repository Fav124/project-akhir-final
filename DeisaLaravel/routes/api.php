<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\SantriApiController;
use App\Http\Controllers\Api\SakitApiController;
use App\Http\Controllers\Api\ObatApiController;
use App\Http\Controllers\Api\KelasApiController;
use App\Http\Controllers\Api\JurusanApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public Auth Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Protected Routes (Requires Authentication)
Route::middleware('auth:sanctum')->group(function () {

  // Auth
  Route::post('/logout', [AuthController::class, 'logout']);
  Route::get('/user', [AuthController::class, 'user']);

  // Admin Only Routes
  Route::middleware('admin.api')->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard']);

    // User Management
    Route::get('/users/pending', [AdminController::class, 'getPendingUsers']);
    Route::post('/users/{id}/approve', [AdminController::class, 'approveUser']);
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);

    // Activity Logs
    Route::get('/activities', [AdminController::class, 'getActivities']);

    // Notifications
    Route::get('/notifications', [AdminController::class, 'getNotifications']);
  });

  // Santri Routes (Admin: full CRUD, Staff: read only)
  Route::get('/santri', [SantriApiController::class, 'index']);
  Route::get('/santri/{id}', [SantriApiController::class, 'show']);
  Route::post('/santri', [SantriApiController::class, 'store']); // Admin only (checked in controller)
  Route::put('/santri/{id}', [SantriApiController::class, 'update']); // Admin only (checked in controller)
  Route::delete('/santri/{id}', [SantriApiController::class, 'destroy']); // Admin only (checked in controller)

  // Sakit Routes (Admin & Staff: CRUD, but delete is admin only)
  Route::get('/sakit', [SakitApiController::class, 'index']);
  Route::get('/sakit/{id}', [SakitApiController::class, 'show']);
  Route::post('/sakit', [SakitApiController::class, 'store']);
  Route::put('/sakit/{id}', [SakitApiController::class, 'update']);
  Route::delete('/sakit/{id}', [SakitApiController::class, 'destroy']); // Admin only (checked in controller)

  // Obat Routes (Admin & Staff: CRUD + restock, but delete is admin only)
  Route::get('/obat', [ObatApiController::class, 'index']);
  Route::get('/obat/{id}', [ObatApiController::class, 'show']);
  Route::post('/obat', [ObatApiController::class, 'store']);
  Route::put('/obat/{id}', [ObatApiController::class, 'update']);
  Route::post('/obat/{id}/restock', [ObatApiController::class, 'restock']);
  Route::delete('/obat/{id}', [ObatApiController::class, 'destroy']); // Admin only (checked in controller)

  // Kelas Routes (All: read, Admin: CRUD)
  Route::get('/kelas', [KelasApiController::class, 'index']);
  Route::get('/kelas/{id}', [KelasApiController::class, 'show']);
  Route::post('/kelas', [KelasApiController::class, 'store']); // Admin only (checked in controller)
  Route::put('/kelas/{id}', [KelasApiController::class, 'update']); // Admin only (checked in controller)
  Route::delete('/kelas/{id}', [KelasApiController::class, 'destroy']); // Admin only (checked in controller)

  // Jurusan Routes (All: read, Admin: CRUD)
  Route::get('/jurusan', [JurusanApiController::class, 'index']);
  Route::get('/jurusan/{id}', [JurusanApiController::class, 'show']);
  Route::post('/jurusan', [JurusanApiController::class, 'store']); // Admin only (checked in controller)
  Route::put('/jurusan/{id}', [JurusanApiController::class, 'update']); // Admin only (checked in controller)
  Route::delete('/jurusan/{id}', [JurusanApiController::class, 'destroy']); // Admin only (checked in controller)
});
