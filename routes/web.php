<?php

use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\NotificationController;
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
    Route::redirect('/', '/login');
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);

    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markRead'])->name('notifications.mark-read');

    Route::get('/medical-records', [MedicalRecordsController::class, 'index'])->name('medical-records');
    Route::get('/medical-records/list', [MedicalRecordsController::class, 'list'])->name('medical-records.list');
    Route::post('/medical-records/store', [MedicalRecordsController::class, 'store'])->name('medical-records.store');
    Route::get('/medical-records/{id}', [MedicalRecordsController::class, 'show'])->name('medical-records.show');
    Route::post('/medical-records/update', [MedicalRecordsController::class, 'update'])->name('medical-records.update');
    Route::delete('/medical-records/delete/{id}', [MedicalRecordsController::class, 'delete'])->name('medical-records.delete');

    Route::get('/appointments', [AppointmentsController::class, 'index'])->name('appointments');
    Route::get('/appointments/list', [AppointmentsController::class, 'list'])->name('appointments.list');
    Route::post('/appointments/store', [AppointmentsController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{id}', [AppointmentsController::class, 'show'])->name('appointments.show');
    Route::post('/appointments/update', [AppointmentsController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/delete/{id}', [AppointmentsController::class, 'delete'])->name('appointments.delete');
    Route::put('/appointments/cancel/{id}', [AppointmentsController::class, 'cancel'])->name('appointments.cancel');
    Route::put('/appointments/confirm/{id}', [AppointmentsController::class, 'confirm'])->name('appointments.confirm');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    //Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    // Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/logout', [LogoutController::class, 'destroy'])->name('logout');

     // Profile-management only for admin and doctor
    Route::middleware('role:admin,doctor')->group(function () {
        Route::get('/profile-patient-management', [ProfilePatientManagementController::class, 'index'])->name('profile-patient-management');
        Route::post('profile-patient-management/store', [ProfilePatientManagementController::class, 'store'])->name('profile-patient-management.store');
        Route::post('profile-patient-management/update', [ProfilePatientManagementController::class, 'update'])->name('profile-patient-management.update');
        Route::delete('profile-patient-management/delete/{id}', [ProfilePatientManagementController::class, 'delete'])->name('profile-patient-management.delete');
        Route::get('profile-patient-management/patient/{id}', [ProfilePatientManagementController::class, 'patient'])->name('profile-patient-management.patient');
        Route::get('profile-patient-management/list', [ProfilePatientManagementController::class, 'list'])->name('profile-patient-management.list');
    });
    
});
