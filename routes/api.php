<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Feed\FeedController;
use App\Http\Controllers\Feed\GroupController;
use App\Http\Controllers\General\CoursesController;
use App\Http\Controllers\General\UniversityController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\User\EventController;
use App\Http\Controllers\User\MessagesController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\RooomateController;
use App\Http\Controllers\UserLists;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user/profile/{id}', [ProfileController::class, 'index']);
    Route::post('/user/profile', [ProfileController::class, 'updateProfile']);
    Route::post('/user/profile/minor', [ProfileController::class, 'updateMinor']);
    Route::post('/user/profile/hobby', [ProfileController::class, 'updateHobby']);
    Route::post('/user/profile/interest', [ProfileController::class, 'updateInterest']);
    Route::post('/user/follow/{userID}', [\App\Http\Controllers\User\FriendController::class, 'followUser']);
    Route::get('/user/follow/{userID}', [\App\Http\Controllers\User\FriendController::class, 'checkIfFreinds']);
    Route::get('/user/friends', [\App\Http\Controllers\User\FriendController::class, 'getMyFriends']);
    Route::post('/user/profile/updateimage', [ProfileController::class, 'updateImage']);
    Route::get('/user/recents', [ProfileController::class, 'getRecentPosts']);
    Route::get('/feed', [FeedController::class, 'index']);
    Route::get('/feed/following/', [FeedController::class, 'following']);
    Route::post('/feed/post', [FeedController::class, 'store']);
    Route::delete('/feed/delete/{feed_id}', [FeedController::class, 'deleteFeed']);
    Route::post('/feed/like/{id}', [FeedController::class, 'react']);
    Route::get('/feed/like/{user_id}/{feed_id}', [FeedController::class, 'checkLike']);
    Route::post('/feed/comment/{id}', [FeedController::class, 'makeComment']);
    Route::post('/feed/savefeed/{id}', [FeedController::class, 'saveFeed']);
    Route::get('/feed/savefeed', [FeedController::class, 'getSavedFeeds']);
    Route::get('/feed/comments/{id}', [FeedController::class, 'comments']);
    Route::get('/chat/{userid}/{receiverid}', [MessagesController::class, 'receive']);
    Route::post('/message/{userid}/{receiverid}', [MessagesController::class, 'send']);
    Route::post('/event/create', [EventController::class, 'store']);
    Route::get('/event/getFriends', [EventController::class, 'getFriendsToInvite']);
    Route::get('/events', [EventController::class, 'getUserEvents']);
    Route::get('/events/explore', [EventController::class, 'explore']);
    Route::get('/event/{eventId}', [EventController::class, 'getEvent']);
    Route::get('/event/attendance/{eventId}', [EventController::class, 'getAttendance']);
    Route::post('/event/scanTicket/{eventId}', [EventController::class, 'scanTicket']);
    Route::post('/event/pay/{eventId}', [PaymentController::class, 'pay']);
    Route::post('/room/create', [RooomateController::class, 'store']);
    Route::post('/group/create', [GroupController::class, 'store']);
    Route::get('/groups', [GroupController::class, 'index']);
    Route::get('/mygroups', [GroupController::class, 'myGroup']);
    Route::post('/joingroup/{group_id}', [GroupController::class, 'joinGroup']);
    Route::get('/checkuser/{group_id}', [GroupController::class, 'checkIfInGroup']);
    Route::post('/createGroupPost', [GroupController::class, 'createGroupPost']);
    Route::get('/fetchGroupPost/{group_id}', [GroupController::class, 'fetchGroupPost']);
    Route::get('/rooms', [RooomateController::class, 'index']);
    Route::get('/room/{room}', [RooomateController::class, 'view']);
    Route::get('/users', [UserLists::class, 'index']);
});

Route::get('/hash', function () {
    return Hash::make('Oladel12');
});


Route::post('checkemail', [AuthController::class, 'checkEmail']);
Route::post('changepassword', [AuthController::class, 'changePassword']);

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('verify', [AuthController::class, 'verifyOtp'])->name('verify');
Route::post('login', [AuthController::class, 'login'])->name('login');


Route::resource('courses', CoursesController::class);
Route::resource('universities', UniversityController::class);
