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

// Tickets
Route::resource('/garages/{garage}/tickets', 'Api\TicketController')->only(['store', 'update']);
Route::get('/garages/{garage}/tickets/{licence}', 'Api\TicketController@show');
Route::delete('/garages/{garage}/tickets/{licence}', 'Api\TicketController@destroy');

// Rates
Route::resource('/rates', 'Api\RateController')->only(['index']);

// Garages
Route::resource('/garages', 'Api\GarageController')->only(['show']);