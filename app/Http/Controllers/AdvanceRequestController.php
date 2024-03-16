<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\AdvanceRequest;


class AdvanceRequestController extends Controller

{
    //
    //create advance request
    public function createAdvanceRequest(Request $request){
        //validate
        try{
            $request->validate([
                'username' => 'required',
                'description' => 'required',
                'amount' => 'required'
            ]);
            //validate if username is a driver
            $driver = Driver::where('username', $request->username)->first();
            if($driver == null){
                return response()->json(['error' => 'Driver not found'], 400);
            }
            //check drivers this month advace total
            $totalAdvance = AdvanceRequest::where('username', $request->username)->where('status','approved')->whereMonth('date', date('m'))->sum('amount');

            $finalTotalAdvance = $totalAdvance + $request->amount;

            //check if amount is higher than drivers salary
            if($finalTotalAdvance > $driver->salary){
                return response()->json(['error' => 'Amount is higher than your salary'], 400);
            }

            //add today date
            $request['date'] = date('Y-m-d');


            //add status pending
            $request['status'] = 'pending';
            return AdvanceRequest::create($request->all());
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    //get all advance requests by driver username
    public function getAdvanceRequests($username){
        return AdvanceRequest::where('username', $username)->get();
    }
    //approve or decline advance request
    public function approveOrDeclineAdvanceRequest(Request $request){
        //validate
        try{
            $request->validate([
                'id' => 'required',
                'username' => 'required',
                'date' => 'required',
                'revieved_by' => 'required',
                'status' => 'required',
                'remarks' => 'required',
                'amount' => 'required'
            ]);
            //if status is approved check if drivers total advance for this month is above salary with amount
            if($request->status == 'approved'){
                //get driver
                $driver = Driver::where('username', $request->username)->first();
                //check drivers this month advace total
                $totalAdvance = AdvanceRequest::where('username', $request->username)->where('status','approved')->whereMonth('date', date('m'))->sum('amount');
                $finalTotalAdvance = $totalAdvance + $request->amount;
                //check if amount is higher than drivers salary
                if($finalTotalAdvance > $driver->salary){
                    return response()->json(['error' => 'Total advance payment are more than drivers salary. Maximum advance is LKR : '.($driver->salary-$totalAdvance)], 400);
                }
            }
            //update status and remarks
            $advanceRequest = AdvanceRequest::where('id', $request->id)->firstOrFail()
            ->update([
                'status' => $request->status,
                'remarks' => $request->remarks,
                'revieved_by' => $request->revieved_by
            ]);
            return response()->json(['message' => 'Advance request updated'], 200);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    //get all pending advance requests
    public function getPendingAdvanceRequests(){
        return AdvanceRequest::where('status', 'pending')->get();
    }
    //get all approved advance requests by driver username
    public function getApprovedAdvanceRequests($username){
        return AdvanceRequest::where('username', $username)->where('status', 'approved')->get();
    }
}
