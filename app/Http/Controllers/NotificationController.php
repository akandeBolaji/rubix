<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\User;
use Nahid\Talk\Facades\Talk;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Events\MessageSent;

class NoificationController extends Controller
{
    public function getNotifications(){
        //return response()->json('success', 201);
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response()->json(['authenticated' => false],422);
        }
        $user = JWTAuth::parseToken()->authenticate();
        $notifications = $user->notifications;
        return response()->json(compact('user', 'notifications'), 201);
    }
}
