<?php

use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\VisitController;
use App\Http\Controllers\Api\AnalyticsController;
use App\Http\Controllers\Api\ApartmentController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/apartments', [ApartmentController::class, 'index']);
Route::get('/apartments/search', [ApartmentController::class, 'search']);
Route::get('/apartments/show', [ApartmentController::class, 'show']);
Route::get('/apartments/sponsored', [ApartmentController::class, 'sponsored']);
Route::get('/services', [ServiceController::class, 'index']);
Route::post('/guest/messages', [MessageController::class, 'storeMessageFromGuest']);
Route::post('/guest/visits', [VisitController::class, 'storeVisitFromGuest']);
Route::get('/userinfo', [UserController::class, 'index']);
Route::get('/apartments/{id}', [ApartmentController::class, 'show']);
Route::get('/analytics', [AnalyticsController::class, 'getAnalyticsData']);


Route::middleware('web')->group(function () {
    Route::get('/logged-user', [UserController::class, 'show']);
});
