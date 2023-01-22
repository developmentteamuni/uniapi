<?php

use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Web\FeaturesController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [FeaturesController::class, 'index']);


Route::get('/event/success/{userID}', [PaymentController::class, 'success']);
