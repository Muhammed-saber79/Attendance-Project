<?php

use App\Http\Controllers\Admin\EmployeesAttendanceController;
use App\Http\Controllers\Admin\MessagesController;
use Barryvdh\DomPDF\Facade\Pdf;
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
    Route::get('/', function () {
        $pdf = PDF::loadView('Messages.notification')
            ->setPaper('a4', 'portrait');

        $pdf->setOptions(['isPhpEnabled' => true]);
        $pdf->getDomPDF()->setHttpContext([
            'Arabic' => ['UTF-8', 'rtl']
        ]);

        return $pdf->stream();
    })->name('home');//[HomeController::class, 'index'])->name('home');
    Route::resource('teacher_attendence',TeacherAttendenceController::class);
    Route::resource('teachers',TeachersController::class);

    Route::group([
        'middleware' => ['role:Admin']
    ], function () {
        Route::get('delete_all',[TeacherAttendenceController::class,'delete_all'])->name('delete_all');
        Route::get('change_status',[TeacherAttendenceController::class,'change_status']);
        Route::get('/employees', [EmployeesController::class, 'index'])->name('employees.index');
        Route::post('/employees/store', [EmployeesController::class, 'store'])->name('employees.store');
        Route::put('/employees/update/{id}', [EmployeesController::class, 'update'])->name('employees.update');
        Route::delete('/employees/destroy/{id}', [EmployeesController::class, 'destroy'])->name('employees.destroy');

        Route::get('teacher_absense',[TeacherStatusController::class,'absense'])->name('teachers_absense');
        Route::get('teacher_delay',[TeacherStatusController::class,'delay'])->name('teachers_delay');
    });

    Route::group([
        'prefix' => '/employees-attendance',
        'as' => 'employees-attendance.'
    ], function () {
        Route::get('/', [EmployeesAttendanceController::class, 'index'])->name('index');
        Route::get('change_status',[EmployeesAttendanceController::class,'change_status']);
    });

    Route::group([
        'prefix' => '/employees',
        'as' => 'employees-absence.'
    ], function () {
        Route::get('/absence', [EmployeesAbsenceController::class, 'absence'])->name('absence');
        Route::get('/late',[EmployeesAbsenceController::class,'late'])->name('late');
    });

    Route::group([
        'prefix' => '/messages',
        'as' => 'messages.'
    ], function () {
        Route::post('/teacher/notify/{id}', [MessagesController::class, 'notifyTeacher'])->name('notifyTeacher');
        Route::post('/teacher/decide/{id}', [MessagesController::class, 'notifyTeacher'])->name('decideTeacher');
        Route::post('/employee/notify/{id}', [MessagesController::class, 'notifyEmployee'])->name('notifyEmployee');
        Route::post('/employee/decide/{id}', [MessagesController::class, 'notifyEmployee'])->name('decideEmployee');
    });
});
