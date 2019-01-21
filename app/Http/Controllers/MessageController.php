<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\User;
use Nahid\Talk\Facades\Talk;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Contracts\JWTSubject as JWTSubject;
use App\Events\MessageSent;

class MessageController extends Controller
{
    function __construct()
    {
        Talk::setAuthUserId(JWTAuth::parseToken()->authenticate()->id);
    }
    public function getThreads(){
        //return response()->json('success', 201);
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response()->json(['authenticated' => false],422);
        }
        $user = JWTAuth::parseToken()->authenticate();
        //$friendships = $user->getAllFriendships();
        $threads = Talk::threads();
        return response()->json(compact('user', 'threads'), 201);
    }

    public function getMessage($id, $page){
        $authuser = JWTAuth::parseToken()->authenticate();
        $user = User::find($id);
        if (!$authuser->isFriendWith($user)  && $user->type == 'user') {
            return response()->json(['msg' => 'Not Allowed'], 401);
        }
        if ($page == 50){
            $lower = 0;
        }
        $lower = $page - 50;
        $upper = $page;
        $conversations = Talk::getMessagesByUserId($id, $lower, $upper);
        $messages = [];
        //$time = $conversations->HumansTime;
        if(!$conversations) {
            $user = User::find($id);
        } else {
            $user = $conversations->withUser;
            $messages = $conversations->messages;
            $messages_count = $conversations->count;
            foreach($messages as $message) {
                if ($message->sender->id != $authuser->id){
                 Talk::makeSeen($message->id);
                }
            }
        }
        if (count($messages) > 0) {
            $messages = $messages->sortBy('id');
        }
        //return view('messages.conversations', compact('messages', 'user'));
        return response()->json(['msg' => $messages, 'count' => $messages_count, 'user' => $user, 'authuser' => $authuser], 200);
    }

     public function newMessage(Request $request){
         $body = $request->message;
         $userId = $request->id;
         $authuser = JWTAuth::parseToken()->authenticate();
         $use = User::find($userId);
         if (!$authuser->isFriendWith($use) && $use->type == 'user') {
             return response()->json(['msg' => 'Not Allowed'], 401);
         }
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

    public function newFile(Request $request){
        $userId = $request->id;
        $authuser = JWTAuth::parseToken()->authenticate();
        $use = User::find($userId);
        if (!$authuser->isFriendWith($use)) {
            return response()->json(['msg' => 'Not Allowed'], 401);
        }
           $file = $request->file('file');
           $destinationPath = 'message_files';
           $filename = $file->getClientOriginalName();
           $file->move($destinationPath, $filename);
        if ($message = Talk::sendFileByUserId($userId, $filename)) {
            $user = JWTAuth::parseToken()->authenticate();
            $receiver = User::where('id', '=', $userId)->first();

            broadcast(new MessageSent($user, $message, $receiver));
            return response()->json(['status'=>'success'], 200);
        }
   }

   public function newImage(Request $request){
    $userId = $request->id;
    $authuser = JWTAuth::parseToken()->authenticate();
    $use = User::find($userId);
    if (!$authuser->isFriendWith($use)) {
        return response()->json(['msg' => 'Not Allowed'], 401);
    }
       $image = $request->file('image');
       $destinationPath = 'message_images';
       $imagename = $image->getClientOriginalName();
       $image->move($destinationPath, $imagename);
    if ($message = Talk::sendImageByUserId($userId, $imagename)) {
        $user = JWTAuth::parseToken()->authenticate();
        $receiver = User::where('id', '=', $userId)->first();
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
