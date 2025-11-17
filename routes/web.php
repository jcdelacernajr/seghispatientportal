<?php

use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\MedicalRecords;
use App\Http\Controllers\MedicalRecordsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilePatientManagementController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });


// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);

    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/medical-records', [MedicalRecordsController::class, 'index'])->name('medical-records');
    Route::get('/appointments', [AppointmentsController::class, 'index'])->name('appointments');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    //Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    // Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/logout', [LogoutController::class, 'destroy'])->name('logout');

     // Profile-management only for admin and doctor
    Route::middleware('role:admin,doctor')->group(function () {
        Route::get('/profile-patient-management', [ProfilePatientManagementController::class, 'index'])->name('profile-patient-management');
        Route::post('profile-patient-management/store', [ProfilePatientManagementController::class, 'store'])->name('profile-patient-management.store');
        Route::get('profile-patient-management/list', [ProfilePatientManagementController::class, 'list'])->name('profile-patient-management.list');
    });
    
});
