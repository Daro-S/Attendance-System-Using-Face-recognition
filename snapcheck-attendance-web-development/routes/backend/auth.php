<?php

use App\Http\Controllers\Backend\AttendanceCohortController;
use App\Http\Controllers\Backend\AttendanceController;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\CourseController;
use App\Http\Controllers\Backend\StudentController;
use App\Http\Controllers\Backend\TestDataController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\CohortController;

use Illuminate\Support\Facades\Auth;
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

Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::controller(UserController::class)->group(function (){
    Route::get('/', 'index')->name('admin');
    Route::get('/user', 'index')->name('user.index');
    Route::get('/user/show/{user}', 'show')->name('user.show');
    Route::post('/user/store', 'store')->name('user.store');
    Route::get('/user/edit/{user}', 'edit')->name('user.edit');
    Route::put('/user/update/{user}', 'update')->name('user.update');
    Route::delete('/user/destroy/{user}','destroy')->name('user.destroy');
});
/*Students Management*/
Route::controller(StudentController::class)->group(function (){
//    Route::get('/', 'index')->name('admin');
    Route::get('/student', 'index')->name('student.index');
    Route::get('/student/show/{student}', 'show')->name('student.show');
    Route::get('/student/create', 'create')->name('student.create');
    Route::post('/student/store', 'store')->name('student.store');
    Route::get('/student/edit/{student}', 'edit')->name('student.edit');
    Route::put('/student/update/{student}', 'update')->name('student.update');
    Route::delete('/student/destroy/{student}','destroy')->name('student.destroy');

    /*ajax*/
    Route::post('/student/storeImage','destroy')->name('student.storeImage');
});
Route::controller(CourseController::class)->group(function (){

    Route::get('/course', 'index')->name('course.index');
    Route::get('/course/show/{course}', 'show')->name('course.show');
    Route::post('/course/store', 'store')->name('course.store');
    Route::get('/course/edit/{course}', 'edit')->name('course.edit');
    Route::put('/course/update/{course}', 'update')->name('course.update');
    Route::delete('/course/destroy/{course}','destroy')->name('course.destroy');
});

/*Attendance group*/
Route::controller(AttendanceController::class)->group(function (){
    Route::get('/attendance', 'index')->name('attendance.index');
    Route::get('/attendance/show/{attendance}', 'show')->name('attendance.show');
    Route::post('/attendance/store', 'store')->name('attendance.store');
    Route::get('/attendance/edit/{attendance}', 'edit')->name('attendance.edit');
    Route::put('/attendance/update/{attendance}', 'update')->name('attendance.update');
    Route::delete('/attendance/destroy/{attendance}',  'destroy')->name('attendance.destroy');
    Route::get('/attendance/create', 'create')->name('attendance.create');

    Route::get('/attendance_cohort_and_date', 'getAttendance')->name('attendance.getAttendance');

    Route::get('/attendance_camera_or_statistic','attendanceCameraOrStatistic')->name('attendance.attendanceCameraOrStatistic');
    Route::get('/attendance_report_specific_course_session','attendanceReportSpecificCourseSession')->name('attendance.attendanceReportSpecificCourseSession');
});

Route::controller(CohortController::class)->group(function (){
//    Route::get('/', 'index')->name('admin');
    Route::get('/cohort', 'index')->name('cohort.index');
    Route::get('/cohort/show/{cohort}', 'show')->name('cohort.show');
    Route::post('/cohort/store', 'store')->name('cohort.store');
    Route::get('/cohort/edit/{cohort}', 'edit')->name('cohort.edit');
    Route::put('/cohort/update/{cohort}', 'update')->name('cohort.update');
    Route::delete('/cohort/destroy/{cohort}','destroy')->name('cohort.destroy');
});

Route::controller(TestDataController::class)->group(function (){
    Route::post('/test', 'index')->name('testData');
});

Route::delete('/attendance_cohort/destroy',  [AttendanceCohortController::class,'destroy'])->name('attendanceCohort.destroy');

