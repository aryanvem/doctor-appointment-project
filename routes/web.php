<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Doctor profile / booking page
// URL: /doctors/dr-kapil-shukla/8108716370
Route::get('/doctors/{slug}/{phone}', [DoctorController::class, 'show'])
    ->name('doctor.show');

// AJAX: get available slots
Route::get('/api/slots', [DoctorController::class, 'slots'])
    ->name('api.slots');

// Authentication (Email + OTP)
Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
Route::post('/login/send-otp', [AuthController::class, 'sendOtp'])->name('auth.send-otp');
Route::get('/login/verify', [AuthController::class, 'showOtpForm'])->name('auth.otp.form');
Route::post('/login/verify', [AuthController::class, 'verifyOtp'])->name('auth.verify-otp');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Appointments
Route::get('/appointments/book', [AppointmentController::class, 'create'])->name('appointments.create');
Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
Route::get('/appointments/{appointment}/success', [AppointmentController::class, 'success'])->name('appointments.success');
Route::get('/my-appointments', [AppointmentController::class, 'index'])->name('appointments.index');

// Default redirect
Route::get('/', fn() => redirect('/doctors/dr-kapil-shukla/8108716370'));
