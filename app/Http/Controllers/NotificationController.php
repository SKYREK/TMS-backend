<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\ReadNotification;
use App\Models\CommonUser;

class NotificationController extends Controller
{
    //get all notifications
    public function index(){
        return Notification::all();
    }
    //get if notification read
    public function getReadStatus(Request $request){
        try{
            //validate
            $request->validate([
                'username' => 'required',
                'notification_id' => 'required'
            ]);
            //check if ReadNotification exists
            $readNotification = ReadNotification::where('username', $request->username)->where('notification_id', $request->notification_id)->first();
            if($readNotification){
                return response()->json(['read' => true]);
            }else{
                return response()->json(['read' => false]);
            }
        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()]);

        }
    }
    //create notification. But for this the currenUser in request must be a admin
    public function createNotification(Request $request){
        try{
            //validate
            $request->validate([
                'username' => 'required',
                'title' => 'required',
                'body' => 'required'
            ]);
            //get user by username and check if type is admin
            $user = CommonUser::where('username', $request->username)->first();
            if(!$user){
                return response()->json(['error' => 'Invalid username']);
            }
            if($user->account_type != 'admin'){
                return response()->json(['error' => 'User is not admin']);
            }
            //create notification
            $notification = Notification::create([
                'username' => $request->username,
                'title' => $request->title,
                'body' => $request->body
            ]);
            return response()->json(['notification' => $notification]);
        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    //mark notification as read
    public function markAsRead(Request $request){
        try{
            //validate
            $request->validate([
                'username' => 'required',
                'notification_id' => 'required'
            ]);
            //create read notification
            $readNotification = ReadNotification::create([
                'username' => $request->username,
                'notification_id' => $request->notification_id
            ]);
            return response()->json(['readNotification' => $readNotification]);
        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    //get all unread notifications
    public function getUnreadNotifications(Request $request){
        try{
            //validate
            $request->validate([
                'username' => 'required'
            ]);
            //get all notifications
            $notifications = Notification::all();
            //get all read notifications
            $readNotifications = ReadNotification::where('username', $request->username)->get();
            //get all unread notifications
            $unreadNotifications = [];
            foreach($notifications as $notification){
                $found = false;
                foreach($readNotifications as $readNotification){
                    if($notification->id == $readNotification->notification_id){
                        $found = true;
                        break;
                    }
                }
                if(!$found){
                    array_push($unreadNotifications, $notification);
                }
            }
            return response()->json($unreadNotifications);
        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

}
