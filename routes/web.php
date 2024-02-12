<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\AuthController;

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

    });

    Route::group([
        'middleware' => ['role:User']
    ], function () {

    });
});
