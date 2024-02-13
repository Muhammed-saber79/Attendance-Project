<?php

use App\Http\Controllers\Admin\EmployeesAttendanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\TeacherAttendenceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\EmployeesController;
use App\Http\Controllers\Admin\EmployeesAbsenceController;
use App\Http\Controllers\Admin\TeachersController;
use App\Http\Controllers\Admin\TeacherStatusController;

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
Route::redirect('/', '/admin');

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login/do', [AuthController::class, 'do_login'])->name('do_login');

    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
});

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth', 'role:Admin,User']
], function() {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::group([
        'middleware' => ['role:Admin']
    ], function () {
        Route::resource('teacher_attendence',TeacherAttendenceController::class);
        Route::resource('teachers',TeachersController::class);
        Route::get('change_status',[TeacherAttendenceController::class,'change_status']);
        Route::get('/employees', [EmployeesController::class, 'index'])->name('employees.index');
        Route::post('/employees/store', [EmployeesController::class, 'store'])->name('employees.store');
        Route::put('/employees/update/{id}', [EmployeesController::class, 'update'])->name('employees.update');
        Route::delete('/employees/destroy/{id}', [EmployeesController::class, 'destroy'])->name('employees.destroy');

        Route::get('teacher_absense',[TeacherStatusController::class,'absense'])->name('teachers_absense');
        Route::get('teacher_delay',[TeacherStatusController::class,'delay'])->name('teachers_delay');
    });

    Route::group([
        'middleware' => ['role:User']
    ], function () {

    });

    Route::group([
        'prefix' => '/employees-absence',
        'as' => 'employees-absence.'
    ], function () {
        Route::get('/', [EmployeesAttendanceController::class, 'index'])->name('index');
    });
});
