<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgentController;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login/verify', [AuthController::class, 'authenticate'])->name('login_verify');
Route::get('account/verify/{token}', [AuthController::class, 'verifyAccount'])->name('mail.verify');

Route::get('/registration', [AuthController::class, 'register'])->name('register');
Route::post('/registration/store', [AuthController::class, 'store'])->name('registration_submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['admin','is_verify_email']],function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/list', [AdminController::class, 'index'])->name('list');
        Route::get('/destroy/{id}', [AdminController::class, 'destroy'])->name('delete');
    });
});

Route::group(['middleware' => ['agent','is_verify_email']],function () {
    Route::prefix('agent')->name('agent.')->group(function () {
        Route::get('/list', [AgentController::class, 'index'])->name('list');
        Route::get('/destroy/{id}', [AgentController::class, 'destroy'])->name('delete');
    });
});

Route::group(['middleware' => ['user','is_verify_email']],function () {
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/list', [UserController::class, 'index'])->name('list');
        Route::get('/destroy/{id}', [UserController::class, 'destroy'])->name('delete');
    });
});
