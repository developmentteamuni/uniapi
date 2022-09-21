<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Feed\FeedController;
use App\Http\Controllers\General\CoursesController;
use App\Http\Controllers\General\UniversityController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\User\MessagesController;
use App\Http\Controllers\User\ProfileController;
use App\Models\Message;
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
    Route::get('/user/profile/{id}', [ProfileController::class, 'index']);
    Route::post('/user/profile', [ProfileController::class, 'updateProfile']);
    Route::post('/user/profile/updateimage', [ProfileController::class, 'updateImage']);
    Route::get('/user/recents', [ProfileController::class, 'getRecentPosts']);
    Route::get('/feed', [FeedController::class, 'index']);
    Route::post('/feed/post', [FeedController::class, 'store']);
    Route::delete('/feed/delete/{feed_id}', [FeedController::class, 'deleteFeed']);
    Route::post('/feed/like/{id}', [FeedController::class, 'react']);
    Route::post('/feed/comment/{id}', [FeedController::class, 'makeComment']);
    Route::post('/feed/savefeed/{id}', [FeedController::class, 'saveFeed']);
    Route::get('/feed/savefeed', [FeedController::class, 'getSavedFeeds']);
    Route::get('/feed/comments/{id}', [FeedController::class, 'comments']);
    Route::get('/chat/{userid}/{receiverid}', [MessagesController::class, 'receive']);
    Route::post('/message/{userid}/{receiverid}', [MessagesController::class, 'send']);
});

Route::post('checkemail', [AuthController::class, 'checkEmail']);
Route::post('changepassword', [AuthController::class, 'changePassword']);

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('verify', [AuthController::class, 'verifyOtp'])->name('verify');
Route::post('login', [AuthController::class, 'login'])->name('login');


Route::resource('courses', CoursesController::class);
Route::resource('universities', UniversityController::class);