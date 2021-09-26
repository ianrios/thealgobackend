<?php

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

Route::prefix('auth')->group(function () {

    // register new user
    Route::post('/register', [UserController::class, 'register']);
    // login existing user
    Route::post('/login', [UserController::class, 'login']);

    // requires token
    Route::group(['middleware' => ['auth:api']], function () {
        // gets user with all data
        Route::get('/user', [UserController::class, 'index']);
        // log out user
        Route::get('/logout', [UserController::class, 'logout']);
    });
});
