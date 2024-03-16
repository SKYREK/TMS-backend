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

Route::post("/mail", "App\Http\Controllers\CommonUserController@sendEmail");
Route::get('/common_users', 'App\Http\Controllers\CommonUserController@index');
Route::get('/common_users/get_admin_dash', 'App\Http\Controllers\CommonUserController@getBookingCounts');
Route::get('/common_users/get_driver_dash', 'App\Http\Controllers\CommonUserController@getDriverDash');
Route::post('/common_users/password', 'App\Http\Controllers\CommonUserController@changePassword');
Route::get('/common_users/salary_slip', 'App\Http\Controllers\CommonUserController@getSalaryReport');
Route::get('/common_users/login_records', 'App\Http\Controllers\CommonUserController@getLoginRecords');
Route::get('/common_users/drivers', 'App\Http\Controllers\CommonUserController@getAllDrivers');
Route::get('/common_users/userInfo', 'App\Http\Controllers\CommonUserController@getUserInfo');
Route::get('/common_users/{username}', 'App\Http\Controllers\CommonUserController@show');
Route::post('/common_users', 'App\Http\Controllers\CommonUserController@registerUser');
Route::put('/common_users', 'App\Http\Controllers\CommonUserController@update');
Route::post('/common_users/login', 'App\Http\Controllers\CommonUserController@login');
Route::delete('/common_users', 'App\Http\Controllers\CommonUserController@delete');


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
Route::delete('/vehicles/category','App\Http\Controllers\VehicleController@deleteCategory');
Route::put('/vehicles/category','App\Http\Controllers\VehicleController@updateCategory');
Route::delete('/vehicles', 'App\Http\Controllers\VehicleController@deleteVehicle');
Route::put('/vehicles', 'App\Http\Controllers\vehicle_repairs@updateVehicle');
//vehicle repair routes
Route::get('/vehicle_repairs', 'App\Http\Controllers\VehicleController@getVehicleRepairs');
Route::post('/vehicle_repairs', 'App\Http\Controllers\VehicleController@addVehicleRepair');
Route::put('/vehicle_repairs', 'App\Http\Controllers\VehicleController@updateVehicleRepair');

//leave request routes
Route::post('/leave_requests', 'App\Http\Controllers\LeaveRequestController@addLeaveRequest');
Route::put('/leave_requests', 'App\Http\Controllers\LeaveRequestController@approveOrDeclineLeaveRequest');
Route::get('/leave_requests/approved/{username}', 'App\Http\Controllers\LeaveRequestController@getApprovedLeaveRequests');
Route::get('/leave_requests/pending', 'App\Http\Controllers\LeaveRequestController@getPendingLeaveRequests');
Route::get('/leave_requests/{username}', 'App\Http\Controllers\LeaveRequestController@getLeaveRequests');

//booking routes
Route::post('/bookings', 'App\Http\Controllers\BookingController@createBooking');
Route::get('/bookings', 'App\Http\Controllers\BookingController@getAllBookings');
Route::get('/bookings/available_vehicles', 'App\Http\Controllers\BookingController@getAvailableVehicles');
Route::get('/bookings/available_drivers', 'App\Http\Controllers\BookingController@getAvailableDrivers');
Route::get('/bookings/bycustomer', 'App\Http\Controllers\BookingController@getBookingsByUsername');

//advance request routes
Route::post('/advance_requests', 'App\Http\Controllers\AdvanceRequestController@createAdvanceRequest');
Route::put('/advance_requests', 'App\Http\Controllers\AdvanceRequestController@approveOrDeclineAdvanceRequest');
Route::get('/advance_requests/pending', 'App\Http\Controllers\AdvanceRequestController@getPendingAdvanceRequests');
Route::get('/advance_requests/{username}', 'App\Http\Controllers\AdvanceRequestController@getAdvanceRequests');
Route::get('/advance_requests/approved/{username}', 'App\Http\Controllers\AdvanceRequestController@getApprovedAdvanceRequests');

//payment routes
Route::post('/payments', 'App\Http\Controllers\PaymentController@createPayment');
Route::get('/payments/{booking_id}', 'App\Http\Controllers\PaymentController@getPayment');
Route::get('/payments/bycustomer/{username}', 'App\Http\Controllers\PaymentController@getPayments');
//help routes
Route::post('/helps', 'App\Http\Controllers\HelpController@createHelp');
Route::get('/helps', 'App\Http\Controllers\HelpController@getHelps');
Route::get('/helps/by_username', 'App\Http\Controllers\HelpController@getHelpsByUsername');
Route::put('/helps', 'App\Http\Controllers\HelpController@updateReply');

//








