<?php

use App\Http\Controllers\CustomerPagesController;
use App\Http\Controllers\AdminPagesController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BarberController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\CustomerController;
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

Route::get('/', [CustomerPagesController::class, 'index'])->name('home');

Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('create');

Route::post('/appointments', [AppointmentController::class, 'store'])->name('store');

Route::get('/appointments/view', [AppointmentController::class, 'viewAppointments'])->name('appointments.viewAppointments');

Route::post('/appointments/show', [AppointmentController::class, 'showByCode'])->name('appointments.showByCode');

Route::get('/appointments/{code}/edit', [AppointmentController::class, 'editByCode'])->name('appointments.editByCode');

Route::put('/appointments/{code}', [AppointmentController::class, 'updateByCode'])->name('appointments.updateByCode');

Route::get('/booking/confirm', [CustomerPagesController::class, 'confirm_booking'])->name('confirm_booking');


