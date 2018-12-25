<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\User;
use Nahid\Talk\Facades\Talk;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Events\MessageSent;

class MessageController extends Controller
{
    function __construct()
    {
        Talk::setAuthUserId(JWTAuth::parseToken()->authenticate()->id);
    }

    public function getMessage($id){
        $conversations = Talk::getMessagesByUserId($id, 0, 1000);
        $user = '';
        $authuser = JWTAuth::parseToken()->authenticate();
        $messages = [];
        //$time = $conversations->HumansTime;
        if(!$conversations) {
            $user = User::find($id);
        } else {
            $user = $conversations->withUser;
            $messages = $conversations->messages;
        }
        if (count($messages) > 0) {
            $messages = $messages->sortBy('id');
        }
        //return view('messages.conversations', compact('messages', 'user'));
        return response()->json(['status'=>'success', 'msg' => $messages, 'user' => $user, 'authuser' => $authuser], 200);
    }

     public function newMessage(Request $request){
         $body = $request->message;
         $userId = $request->id;
         if ($message = Talk::sendMessageByUserId($userId, $body)) {
             //$html = view('ajax.newMessageHtml', compact('message'))->render();
             //return response()->json(['status'=>'success', 'html'=>$html], 200);
             $user = JWTAuth::parseToken()->authenticate();
             $receiver = User::where('id', '=', $userId)->first();
             //event(new ShippingStatusUpdated($update));
             broadcast(new MessageSent($user, $message, $receiver));
             return response()->json(['status'=>'success'], 200);
         }

    }

    public function deleteMessage($id){
        if(Talk::deleteMessage($id)) {
            return response()->json(['status'=>'success'], 200);
        }
        return response()->json(['status'=>'errors', 'msg'=>'something went wrong'], 401);
    }

}
