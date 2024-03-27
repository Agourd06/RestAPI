<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReservaController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['check.role:organisateur'])->group(function () {
    Route::controller(EventController::class)->group(function () {
        Route::post('storeEvent', 'store');
    });
    Route::controller(ReservaController::class)->group(function () {
        Route::get('dataReservations', 'index');
        Route::put('updateStatut/{id}', 'updateStatut');
    });
});

Route::controller(AuthController::class)->group(function () {
    Route::post('logout', 'logout')->middleware('auth:api');


    Route::post('login', 'login');
    Route::post('register', 'register');
});
Route::middleware(['check.role:benevole'])->group(function () {

    Route::controller(ReservaController::class)->group(function () {
        Route::post('storeReservation/{id}', 'store');
    });
  
});
Route::controller(EventController::class)->group(function () {
    Route::get('dataEvents', 'index');
});