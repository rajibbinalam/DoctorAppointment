<?php

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
//     return view('home');
// });


Route::get('/',[App\Http\Controllers\HomeController::class,'index'])->name('home.index');


// Doctor Controller
Route::get('/doctor',[App\Http\Controllers\DoctorController::class,'index'])->name('doctor.index');
Route::post('/doctor',[App\Http\Controllers\DoctorController::class,'insert'])->name('doctor.insert');
Route::get('/doctor/edit/{id}',[App\Http\Controllers\DoctorController::class,'DocEdit'])->name('doctor.DocEdit');
Route::post('/doctor/update/{id}',[App\Http\Controllers\DoctorController::class,'DocUpdate'])->name('doctor.DocUpdate');
Route::get('/doctor/delete/{id}',[App\Http\Controllers\DoctorController::class,'DocDelete'])->name('doctor.DocDelete');


//Appointment
Route::get('/appointment',[App\Http\Controllers\AppointmentController::class,'index'])->name('appointment.index');
Route::get('/select-dept/{id}',[App\Http\Controllers\AppointmentController::class,'selectDept']);
Route::get('/select-Doc-fee/{id}',[App\Http\Controllers\AppointmentController::class,'selectDocFee']);

Route::post('/appointment',[App\Http\Controllers\AppointmentController::class,'InsertAppointment'])->name('InsertAppointment');



Route::post('/session-data',[App\Http\Controllers\AppointmentController::class,'SessionData'])->name('sessionData');

Route::get('/destro-session',[App\Http\Controllers\AppointmentController::class,'SessionDestroy'])->name('SessionDestroy');
