<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\PlaylistTrackController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\TrackStatisticController;
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

// Route::group(['middleware' => ['cors']], function () {

Route::prefix('playlist')->group(function () {

    // TODO: move all playlist generating code to backend
    // Route::get('/create', [PlaylistController::class, 'new playlist to send to front end']);
    // Route::post('/track/save', [PlaylistController::class, 'new song info to save from current playlist']);
    // Route::post('/track/ like / dislike', [PlaylistController::class, 'new song info to save from current playlist']);
    // Route::post('/track/ increment plays', [PlaylistController::class, 'new song info to save from current playlist']);


    // get all playlist data
    Route::get('/get/all', [PlaylistController::class, 'index']);

    // get user track data combined with final result
    Route::get('/result', [TrackController::class, 'index']);

    // requires token
    Route::group(['middleware' => ['auth:api']], function () {
        // save new playlist
        Route::post('/save', [PlaylistController::class, 'store']);
    });
});


Route::prefix('auth')->group(function () {

    // register new user
    Route::get('/register', [UserController::class, 'register']);
    // login existing user
    Route::post('/login', [UserController::class, 'login']);

    // requires token
    Route::group(['middleware' => ['auth:api']], function () {
        // gets user with all data
        Route::get('/user', [UserController::class, 'index']);
        // log out user
        Route::get('/logout', [UserController::class, 'logout']);
        // check status
        Route::get('/status', [UserController::class, 'index']);
    });
});
