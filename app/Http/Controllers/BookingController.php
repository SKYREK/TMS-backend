<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\LeaveRequest;
use App\Models\CommonUser;


class BookingController extends Controller
{
    //create booking
    /*
    username
driver_username
date
vehicle_reg_no
distance
cost
payment_status
remarks
    */
    public function createBooking(Request $request){
        $request->validate([
            'username' => 'required',
            'driver_username' => 'required',
            'date' => 'required',
            'vehicle_reg_no' => 'required',
            'distance' => 'required',
            'cost' => 'required',
            'payment_status' => 'required',
            'remarks' => 'required'
        ]);
        //validate if driver have another booking for that date
        $booking = Booking::where('driver_username', $request->driver_username)->where('date', $request->date)
        ->first();
        if($booking != null){
            return response()->json(['error' => 'Driver already have a booking for that date'], 400);
        }
        //validate if vehicle have another booking for that date
        $booking = Booking::where('vehicle_reg_no', $request->vehicle_reg_no)->where('date', $request->date)
        ->first();
        if($booking != null){
            return response()->json(['error' => 'Vehicle already have a booking for that date'], 400);
        }
        $booking = new Booking();
        $booking->username = $request->username;
        $booking->driver_username = $request->driver_username;
        $booking->date = $request->date;
        $booking->vehicle_reg_no = $request->vehicle_reg_no;
        $booking->distance = $request->distance;
        $booking->cost = $request->cost;
        $booking->payment_status = $request->payment_status;
        $booking->remarks = $request->remarks;
        $booking->save();
        return response()->json([
            'message' => 'Booking created successfully'
        ], 201);
    }
    //get vehicles that have matching category and not having bookings for given date
    public function getAvailableVehicles(Request $request){
        $request->validate([
            'date' => 'required',
            'category' => 'required'
        ]);
        $vehicles = Booking::where('date', $request->date)->pluck('vehicle_reg_no');
        return Vehicle::where('category', $request->category)->whereNotIn('reg_no', $vehicles)->get();
    }
    //get drivers that are not having bookings for given date
    public function getAvailableDrivers(Request $request){
        $request->validate([
            'date' => 'required'
        ]);
        $drivers = Booking::where('date', $request->date)->pluck('driver_username');
        //check divers without approved leave requests
        $leaveRequests = LeaveRequest::where('date', $request->date)->where('status', 'approved')->pluck('username');
        $freeDrivers = Driver::whereNotIn('username', $drivers)->whereNotIn('username', $leaveRequests)->get();
        //add name from common users
        foreach($freeDrivers as $driver){
            //get common user
            $user = CommonUser::where('username', $driver->username)->first();
            $driver['name'] = $user->name;
        }
        return $freeDrivers;
    }
    //get bookings by username
    public function getBookingsByUsername(Request $request){
        $request->validate([
            'username' => 'required'
        ]);
        return Booking::where('username', $request->username)->get();
    }
    //getAllBookings
    public function getAllBookings(){
        return Booking::all();
    }
}
