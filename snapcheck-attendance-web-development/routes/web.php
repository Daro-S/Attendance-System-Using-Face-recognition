<?php

use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\CourseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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

if (App::environment('production')) {
    URL::forceScheme('https');
}

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', [AuthController::class, 'login_form'])->name('login_form');

Route::get('/login', [AuthController::class, 'login_form'])->name('login_form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::controller(UserController::class)->group(function (){
    Route::get('/', [UserController::class, 'index'])->name('admin');
    Route::get('/user', [UserController::class, 'index'])->name('user.index');

});
Route::controller(Course::class)->group(function (){
    Route::get('/', [CourseController::class, 'index'])->name('admin');
    Route::get('/course', [CourseController::class, 'index'])->name('course.index');

});
