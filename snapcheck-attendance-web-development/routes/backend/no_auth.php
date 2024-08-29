<?php

use App\Http\Controllers\Backend\AttendanceController;
use App\Http\Controllers\Backend\AuthController;
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

Route::get('/', [AuthController::class, 'login_form'])->name('login_form');

Route::get('/login', [AuthController::class, 'login_form'])->name('login_form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/attendance/setExpired', [AttendanceController::class, 'setExpired'])->name('setExpired');

Route::controller(AttendanceController::class)->group(function (){
    //Ajax request of attendance.getAttendanceIdByCourseId
    Route::get('/getAttendanceIdByCourseId','getAttendanceIdByCourseId')->name('attendance.getAttendanceIdByCourseId');
    Route::get('/getCohortsByAttendanceId','getCohortsByAttendanceId')->name('attendance.getCohortsByAttendanceId');
    Route::get('/getAttendanceById','getAttendanceById')->name('attendance.getAttendanceById');
});
