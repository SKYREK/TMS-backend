<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\LeaveRequest;
use App\Models\Booking;

class LeaveRequestController extends Controller
{
    //add a leave request
    public function addLeaveRequest(Request $request){
        //validate
        try{
            $request->validate([
                'username' => 'required',
                'date' => 'required',
                'description' => 'required'
            ]);
            //validate if username is a driver
            $driver = Driver::where('username', $request->username)->first();
            if($driver == null){
                return response()->json(['error' => 'Driver not found'], 400);
            }

            //change date to yyyy-mm-dd
            $date = date('Y-m-d', strtotime($request->date));
            $request['date'] = $date;
            //check if there is already a request for that date
            $leaveRequest = LeaveRequest::where('username', $request->username)->where('date', $request->date)
            ->first();
            if($leaveRequest != null){
                return response()->json(['error' => 'Leave request already exists'], 400);
            }
            //check if there any booking for the driver that day
            $booking = Booking::where('driver_username', $request->username)->where('date', $request->date)
            ->first();
            if($booking != null){
                return response()->json(['error' => 'You are having a booking that day.'], 400);
            }

            return LeaveRequest::create($request->all());
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    //get users all requests
    public function getLeaveRequests($username){
        return LeaveRequest::where('username', $username)->get();
    }
    //approve leave request
    public function approveOrDeclineLeaveRequest(Request $request){
        //validate
        try{
            $request->validate([
                'username' => 'required',
                'date' => 'required',
                'revieved_by' => 'required',
                'status' => 'required',
                'remarks' => 'required'
            ]);
            $leaveRequest = LeaveRequest::where('username', $request->username)->where('date', $request->date)
            ->firstOrFail();
            $leaveRequest->update($request->all());

            return $leaveRequest;
            //return $request;
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    //get users approved requests
    public function getApprovedLeaveRequests($username){
        return LeaveRequest::where('username', $username)->where('status', 'approved')->get();
    }
    //get all pending requests
    public function getPendingLeaveRequests(){
        return LeaveRequest::where('status', 'pending')->get();
    }

}
