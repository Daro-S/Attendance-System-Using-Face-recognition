<?php

use App\Http\Controllers\Api\AttendanceCohortController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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

if (App::environment('production')) {
    URL::forceScheme('https');
}

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::group(['prefix' => 'attendance'], function () {
   /* Route::controller(AttendanceController::class)->group(function (){
    });*/

Route::post('/attendance/mark_student_attendance', [AttendanceController::class,'markStudentAttendance'])->name('attendance.markStudentAttendance');
Route::get('/attendance/delete_latest_student_attendance', [AttendanceController::class,'deleteLatestStudentAttendance'])->name('attendance.deleteLatestStudentAttendance');
//});
Route::get('/attendance/setExpired', [AttendanceController::class, 'setExpired'])->name('setExpired');
Route::get('/attendance/setAbsentStudent', [AttendanceController::class, 'setAbsentStudent'])->name('setAbsentStudent');
Route::get('/attendance/getAttendanceIdByCourseId',[AttendanceController::class,'getAttendanceIdByCourseId'])->name('attendance.getAttendanceIdByCourseId');
Route::get('/attendance/getCohortsByAttendanceId',[AttendanceController::class,'getCohortsByAttendanceId'])->name('attendance.getCohortsByAttendanceId');
Route::get('/attendance/getAttendanceById',[AttendanceController::class,'getAttendanceById'])->name('attendance.getAttendanceById');

Route::get('/attendance_cohort_and_date', [AttendanceController::class,'getAttendance'])->name('attendance.getAttendance');
Route::delete('/attendance/destroy/{attendance}',  [AttendanceController::class,'destroy'])->name('attendance.destroy');

Route::get('/student/getStudentImages', [StudentController::class,'getStudentImages'])->name('student.getStudentImages');
Route::delete('/attendance_cohort/destroy/{attendanceCohort}',  [AttendanceCohortController::class,'destroy'])->name('attendanceCohort.destroy');
