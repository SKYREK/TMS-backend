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


Route::get('/common_users', 'App\Http\Controllers\CommonUserController@index');
Route::get('/common_users/login_records', 'App\Http\Controllers\CommonUserController@getLoginRecords');
Route::get('/common_users/{username}', 'App\Http\Controllers\CommonUserController@show');
Route::post('/common_users', 'App\Http\Controllers\CommonUserController@registerUser');
Route::put('/common_users/{username}', 'App\Http\Controllers\CommonUserController@update');
Route::post('/common_users/login', 'App\Http\Controllers\CommonUserController@login');

//notification routes
Route::get('/notifications', 'App\Http\Controllers\NotificationController@index');
Route::post('/notifications', 'App\Http\Controllers\NotificationController@createNotification');
Route::post('/notifications/read_status', 'App\Http\Controllers\NotificationController@getReadStatus');
Route::post('/notifications/read', 'App\Http\Controllers\NotificationController@markAsRead');
Route::get('/notifications/unread', 'App\Http\Controllers\NotificationController@getUnreadNotifications');

//vehicle routes
Route::get('/vehicles', 'App\Http\Controllers\VehicleController@getVehicles');
Route::post('/vehicles', 'App\Http\Controllers\VehicleController@addVehicle');
Route::get('/vehicles/category', 'App\Http\Controllers\VehicleController@getCategories');
Route::post('/vehicles/category', 'App\Http\Controllers\VehicleController@addCategory');
Route::delete('/vehicles', 'App\Http\Controllers\VehicleController@deleteVehicle');
Route::put('/vehicles', 'App\Http\Controllers\VehicleController@updateVehicle');



