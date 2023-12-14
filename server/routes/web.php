<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\UserController;
use App\Models\Appointment;
use App\Models\Branch;
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
    return view('welcome');
});



Route::prefix('dashboard')->middleware(['auth', 'verified', 'administrator'])->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::resource('users', UserController::class);

    Route::get('users/{user}/edit/password', [UserController::class, 'editPassword'])->name('users.edit.password');
    Route::put('users/{user}/edit/password', [UserController::class, 'updatePassword'])->name('users.update.password');

    Route::resource('branches', BranchController::class);
    Route::resource('branches.appointments', AppointmentController::class)->only(['index', 'destroy']);
    Route::resource('branches.donations', DonationController::class)->only(['index', 'destroy']);

    Route::resource('appointments.donations', DonationController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/web_auth.php';
