<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommonUser;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\LoginRecord;
use Illuminate\Support\Facades\Log;

class CommonUserController extends Controller
{
    public function index(){
        return CommonUser::all();
    }
    public function show($username){
        return CommonUser::find($username);
    }
    public function store(Request $request){
        return CommonUser::create($request->all());
    }
    public function update(Request $request, $username){
        $commonUser = CommonUser::findOrFail($username);
        $commonUser->update($request->all());
        return $commonUser;
    }
    public function delete(Request $request, $username){
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
}
