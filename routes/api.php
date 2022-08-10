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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('instagram/feeds/{username}', 'ApiController@instagramFeeds');
Route::get('weather', 'ApiController@weather');
Route::get('notifications/{id}', 'ApiController@notifications');
Route::get('notifications/read/{id}', 'ApiController@notificationsRead');

Route::get('chart/attendance/{user_id}/{month}/{year}', 'ApiController@chart_attendance');
Route::get('chart/discipline/{user_id}/{month}/{year}', 'ApiController@chart_discipline');