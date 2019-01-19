<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::resource('/garage/{garage}/user', 'Api\GarageUserController')->only(['store', 'update', 'destroy']);

Route::resource('/rates', 'Api\RateController')->only(['index']);

Route::resource('/garages', 'Api\GarageController')->only(['show']);