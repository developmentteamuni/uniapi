<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\GeneralController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['auth:sanctum']], function() {
    
});

Route::post('checkemail', [AuthController::class, 'checkEmail']);
Route::post('changepassword', [AuthController::class, 'changePassword']);

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('verify', [AuthController::class, 'verifyOtp'])->name('verify');
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::controller(GeneralController::class)->group(function() {
    Route::get('/general/courses', 'index');
    Route::get('/general/university', 'uni');
});