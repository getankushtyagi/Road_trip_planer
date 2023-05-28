<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\ResetController;
use App\Http\Controllers\v1\RoadTripController;
use App\Http\Controllers\v1\StopController;
use App\Http\Controllers\v1\UserController;
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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::group(['middleware' => ['auth:api']], function () {

    //user APIs
    Route::get('user',[UserController::class,'userDetail'])->name('user-detail');
    Route::put('user',[UserController::class,'userDetailUpdate'])->name('user-detail-update');
    Route::delete('user',[UserController::class,'userDelete'])->name('user-delete');

    //Road Trip API:
    Route::get('road-trips',[RoadTripController::class,'myTrips'])->name('my-trips');
    Route::post('road-trips',[RoadTripController::class,'createTrip'])->name('create-trip');
    Route::get('road-trips/{id}',[RoadTripController::class,'tripDetail'])->name('trip-detail');
    Route::put('road-trips/{id}',[RoadTripController::class,'tripDetailUpdate'])->name('trip-detail-update');
    Route::delete('road-trips/{id}',[RoadTripController::class,'tripDelete'])->name('trip-delete');

    //stops APIs
    Route::get('road-trips/{road_trip_id}/stops',[StopController::class,'myStops'])->name('my-stops');
    Route::post('road-trips/{road_trip_id}/stops',[StopController::class,'createStop'])->name('create-stop');
    Route::get('road-trips/{road_trip_id}/stops/{id}',[StopController::class,'tripStopDetail'])->name('trip-stop-detail');
    Route::put('road-trips/{road_trip_id}/stops/{id}',[StopController::class,'updateStop'])->name('update-stop');
    Route::delete('road-trips/{road_trip_id}/stops/{id}',[StopController::class,'deleteStop'])->name('delete-stop');
});
