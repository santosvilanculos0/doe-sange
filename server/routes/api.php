<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\ReportController;
use App\Models\Appointment;
use App\Models\Branch;
use Illuminate\Http\Request;
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



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::put('/account', [AccountController::class, 'update']);
    Route::put('/account/password', [AccountController::class, 'password']);
    Route::get('/account/donations', [AccountController::class, 'donations']);
    Route::get('/account/appointments', [AccountController::class, 'appointments']);
    Route::put('/account/appointments/{appointment}/cancel', [AccountController::class, 'cancelAppointment']);

    Route::get('/branches', [BranchController::class, 'index']);
    Route::get('/branches/{branch}', [BranchController::class, 'show']);
    Route::post('/branches/{branch}/appointments', [AppointmentController::class, 'store']);
});



require __DIR__ . '/api_auth.php';
