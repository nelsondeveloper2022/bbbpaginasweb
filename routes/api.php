<?php

use App\Http\Controllers\Api\EmpresaController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\ValidationController;
use App\Http\Controllers\Api\LicenseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/empresa', [EmpresaController::class, 'getEmpresa']);
Route::post('/empresa/planes', [PlanController::class, 'getPlanesByEmpresa']);
Route::post('/contact/send', [ContactController::class, 'sendContact']);

// Validation Routes
Route::get('/check-email', [ValidationController::class, 'checkEmail']);

// Wompi Webhook
Route::post('/payments/wompi/webhook', [\App\Http\Controllers\Api\WompiController::class, 'webhook']);

// Protected License API for Make Integration
Route::get('/licenses/all', [LicenseController::class, 'getAllLicenses']);
Route::get('/licenses/process-notifications', [LicenseController::class, 'processExpirationNotifications']);
Route::get('/licenses/notification-stats', [LicenseController::class, 'getNotificationStats']);