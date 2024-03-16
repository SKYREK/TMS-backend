<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommonUser;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\LoginRecord;
use Illuminate\Support\Facades\Log;
use App\Models\LeaveRequest;
use App\Models\AdvanceRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use App\Models\Booking;
use App\Models\Vehicle;



class CommonUserController extends Controller
{
    public function index(){
        $userList =  CommonUser::all();
        //add salary to driver users
        foreach($userList as $user){
            if($user->account_type == 'driver'){
                $driver = Driver::where('username', $user->username)->first();
                $user['salary'] = $driver->salary;
            }else if($user->account_type == 'customer'){
                $customer = Customer::where('username', $user->username)->first();
                $user['address'] = $customer->address;
                $user['phone'] = $customer->phone;
                $user['email'] = $customer->email;
            }
        }
        return $userList;
    }
    public function show($username){
        return CommonUser::find($username);
    }
    public function store(Request $request){
        return CommonUser::create($request->all());
    }
    //get full user info by username
    public function getUserInfo(Request $request){
        $username = $request->username;
        $user = CommonUser::where('username', $username)->first();
        if($user->account_type == 'customer'){
            $customer = Customer::where('username', $username)->first();
            $user['address'] = $customer->address;
            $user['phone'] = $customer->phone;
            $user['email'] = $customer->email;
        }else if($user->account_type == 'driver'){
            $driver = Driver::where('username', $username)->first();
            $user['salary'] = $driver->salary;
        }
        return $user;
    }
    public function update(Request $request){
        $commonUser = CommonUser::findOrFail($request->username);
        $commonUser->name = $request->name;
        $commonUser->gender = $request->gender;
        $commonUser->save();
        //if user type is customer save customer details
        if($commonUser->account_type == 'customer'){
            $customer = Customer::where('username', $commonUser->username)->first();
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->save();
        }
        return $commonUser;
    }
    public function delete(Request $request){
        $username = $request->input('username');
        $commonUser = CommonUser::findOrFail($username);
        $commonUser->delete();
        return 204;
    }
    public function registerUser(Request $request){

        //validate
        try{
            $request->validate([
                'username' => 'required|unique:common_users',
                'name' => 'required',
                'account_type' => 'required',
                'password' => 'required'
            ]);
            if($request->account_type == 'customer'){
                $request->validate([
                    'address' => 'required',
                    'phone' => 'required',
                    'email' => 'required'
                ]);
            }else if($request->account_type == 'driver'){
                $request->validate([
                    'salary' => 'required|numeric',
                ]);
            }
            //hash password
            $request['password'] = bcrypt($request['password']);
            $user = CommonUser::create([
                'username' => $request->username,
                'name' => $request->name,
                'account_type' => $request->account_type,
                'password' => $request->password
            ]);
            //if user type is customer save customer details
            if($request->account_type == 'customer'){
                $customer = Customer::create([
                    'username' => $request->username,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'email' => $request->email
                ]);
                //add data to user
                $user['address'] = $customer->address;
                $user['phone'] = $customer->phone;
                $user['email'] = $customer->email;
            }else if($request->account_type == 'driver'){
                $driver = Driver::create([
                    'username' => $request->username,
                    'salary' => $request->salary,
                ]);
                //add data to user
                $user['salary'] = $driver->salary;
            }
            return response()->json($user, 201);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    //login function
    public function login(Request $request){
        //validate
        Log::info('message');
        try{
            $request->validate([
                'username' => 'required',
                'password' => 'required',
                'region' => 'required',
                'device' => 'required'
            ]);
            //check if user exists
            $user = CommonUser::where('username', $request->username)->first();
            if(!$user){
                return response()->json(['error' => 'Invalid username'], 400);
            }
            //check if password is correct
            if(!\Hash::check($request->password, $user->password)){
                return response()->json(['error' => 'Invalid password'], 400);
            }
            //add driver and customer info
            if($user->account_type == 'customer'){
                $customer = Customer::where('username', $user->username)->first();
                $user['address'] = $customer->address;
                $user['phone'] = $customer->phone;
                $user['email'] = $customer->email;
            }else if($user->account_type == 'driver'){
                $driver = Driver::where('username', $user->username)->first();
                $user['salary'] = $driver->salary;
            }

            $loginRecord = LoginRecord::create([
                'username' => $user->username,
                'region' => $request->region,
                'device' => $request->device
            ]);



            return response()->json($user, 200);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    //get login records by username
    public function getLoginRecords(Request $request){
        try{
            //validate
            $request->validate([
                'username' => 'required'
            ]);
            $records =  LoginRecord::where('username', $request->username)->get();
            return response()->json($records, 200);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }

    }
    //change name of a user
    public function changeName(Request $request){
        try{
            //validate
            $request->validate([
                'username' => 'required',
                'name' => 'required'
            ]);
            $user = CommonUser::where('username', $request->username)->firstOrFail();
            $user->name = $request->name;
            $user->save();
            return response()->json($user, 200);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function getSalaryReport(Request $request){
        //get all leaves for current month by username
        $leaves = LeaveRequest::where('username', $request->username)->whereMonth('date', date('m'))->where('status',"approved")->get();
        //get all advances for current month by username
        $advances = AdvanceRequest::where('username', $request->username)->whereMonth('date', date('m'))->where('status',"approved")->get();
        //get driver
        $driver = Driver::where('username', $request->username)->first();
        //create response with leaves advances and driver
        $response = [
            'leaves' => $leaves,
            'advances' => $advances,
            'driver' => $driver
        ];
        return response()->json($response, 200);
    }
    public function getAllDrivers(){
        return CommonUser::where('account_type', 'driver')->get();
    }
    public function sendEmail(Request $request)
    {
        $email = $request->email;
        $code = $request->code;
        $toEmail = $email;
        $subject = 'Test Email';
        $message = 'Use following code as your verification code: '.$code.'';

        Mail::raw($message, function ($mail) use ($toEmail, $subject) {
            $mail->to($toEmail)
                ->subject($subject);
        });

        return "Email sent successfully!";
    }
    //change password
    public function changePassword(Request $request){
        try{
            //validate
            $request->validate([
                'username' => 'required',
                'password' => 'required'
            ]);
            $user = CommonUser::where('username', $request->username)->firstOrFail();
            $user->password = bcrypt($request->password);
            $user->save();
            return response()->json($user, 200);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    //get counts of all bookings all drivers all customers and all vehicles
    public function getBookingCounts(){
        $bookings = Booking::all();
        $drivers = CommonUser::where('account_type', 'driver')->get();
        $customers = CommonUser::where('account_type', 'customer')->get();
        $vehicles = Vehicle::all();
        $response = [
            'bookings' => count($bookings),
            'drivers' => count($drivers),
            'customers' => count($customers),
            'vehicles' => count($vehicles)
        ];
        return response()->json($response, 200);
    }
    public function getDriverDash(Request $request){
        $username = $request->username;
        $driver = Driver::where('username', $username)->first();
        $bookings = Booking::where('driver_username', $username)->get();
        $leaves = LeaveRequest::where('username', $username)->where('status', 'approved')->get();
        $advances = AdvanceRequest::where('username', $username)->where('status', 'approved')->get();
        $response = [
            'driver' => $driver,
            'bookings' => count($bookings),
            'leaves' => count($leaves),
            'advances' => count($advances)
        ];
        return response()->json($response, 200);
    }
}
//det drivers booking_count leave_count and advance_count by username

