<?php

use App\Http\Controllers\Admin\TopicController;
use App\Http\Controllers\Admin\ExpertiseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PushNotificationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\AdminController;
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

// Admin Login and Registration Here
    Route::namespace('auth')->group(function () {
    Route::get('/login',[LoginController::class,'show_login_form'])->name('admin.showlogin');
    Route::post('/login',[LoginController::class,'process_login'])->name('admin.storelogin');
    Route::get('/register',[LoginController::class,'show_signup_form'])->name('admin.showregister');
    Route::post('/register',[LoginController::class,'process_signup'])->name('admin.storeregister');
    Route::post('/logout',[LoginController::class,'logout'])->name('admin.logout');
    Route::get('reset_password', [LoginController::class,'passwordResetForm'])->name('admin.reset-form');
    Route::post('reset_password_forgot', [LoginController::class,'forgot'])->name('admin.forgot');
    Route::get('confirm-form', [LoginController::class,'confirmForm'])->name('admin.confirm-form');
    Route::post('reset_password_confirm', [LoginController::class,'reset'])->name('admin.pass.code');
     });

// Admin Protected Route Here
  Route::group(['middleware' => ['admin']], function () {
    Route::get('/', [AdminController::class,'index']);
    Route::resource('push-notification', PushNotificationController::class);
    Route::post('send-notification', [PushNotificationController::class,'sendNotification'])->name('send.notification');

      //User
      Route::resource('user', UserController::class);

      //Expertise
      Route::resource('expertise', ExpertiseController::class);

      //Topic
      Route::resource('topic', TopicController::class);



  });
