<?php

use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LocationEventController;
use App\Http\Controllers\PerformerController;
use App\Http\Controllers\PerformerEventController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/performers', [PerformerController::class, 'index']);
Route::get('/performers/paginate', [PerformerController::class, 'indexPaginate']);
Route::get('/performers/{id}', [PerformerController::class, 'show']);

Route::get('/locations', [LocationController::class, 'index']);
Route::get('/locations/paginate', [LocationController::class, 'indexPaginate']);
Route::get('/locations/{id}', [LocationController::class, 'show']);

Route::get('/events', [EventController::class, 'index']);
Route::get('/events/paginate', [EventController::class, 'indexPaginate']);
Route::get('/events/{id}', [EventController::class, 'show']);

Route::resource('performers.events', PerformerEventController::class)
    ->only(['index']);

Route::resource('locations.events', LocationEventController::class)
    ->only(['index']);


Route::post('/register', [AuthorizationController::class, 'register']);
Route::post('/login', [AuthorizationController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });

    Route::resource('/performers', PerformerController::class)
        ->only(['store', 'update', 'destroy']);

    Route::resource('/locations', LocationController::class)
        ->only(['store', 'update', 'destroy']);

    Route::resource('/events', EventController::class)
        ->only(['store', 'update', 'destroy']);

    Route::post('/logout', [AuthController::class, 'logout']);
});
