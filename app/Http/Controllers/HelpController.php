<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Help;

class HelpController extends Controller
{
    //create help
    public function createHelp(Request $request){
        $help = new Help();
        $help->username = $request->username;
        $help->ticket = $request->ticket;
        $help->save();
        return response()->json(["message" => "Help ticket created successfully"]);
    }
    //get all help with reply "not response yet"
    public function getHelps(){
        return Help::where('reply', 'not response yet')->get();
    }
    //get all helps by username
    public function getHelpsByUsername(Request $request){
        return Help::where('username', $request->username)->get();
    }
    //update reply of a ticket
    public function updateReply(Request $request){
        $help = Help::where('id', $request->id)->first();
        $help->reply = $request->reply;
        $help->save();
        return response()->json(["message" => "Reply updated successfully"]);
    }
}
