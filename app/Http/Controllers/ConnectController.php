<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\postImage;
use App\postVideo;
use App\Post;
use Validator;
use App\User;
use Nahid\Talk\Facades\Talk;
use App\Notifications\Activation;
use App\Notifications\Activated;
use App\Notifications\FriendRequest;
use App\Notifications\FriendAccept;
use App\Notifications\PasswordReset;
use App\Notifications\PasswordResetted;


class ConnectController extends Controller
{
    public function getSent(){
        //return response()->json('success', 201);
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response()->json(['authenticated' => false],422);
        }
        $user = JWTAuth::parseToken()->authenticate();
        $pending_friendships = $user->getPendingFriendships()->where('recipient_id', '!=', $user->id)->pluck('recipient_id');
        $pending_friendship = \App\User::whereIn('id', $pending_friendships)->get();
        return response()->json(compact('user', 'pending_friendship'), 201);
    }

    public function getReceived(){
        //return response()->json('success', 201);
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response()->json(['authenticated' => false],422);
        }
        $user = JWTAuth::parseToken()->authenticate();
        $pending_requests = $user->getFriendRequests()->pluck('sender_id');
        $denied_requests = $user->getDeniedFriendships()->pluck('recipient_id');
        $pending_request = \App\User::whereIn('id', $pending_requests)->whereNotIn('id', $denied_requests)->get();
        return response()->json(compact('user', 'pending_request'), 201);
    }
    public function getSuggestions(){
        //return response()->json('success', 201);
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response()->json(['authenticated' => false],422);
        }
        $user = JWTAuth::parseToken()->authenticate();
        //$friendships = $user->getAllFriendships();
        //$friends = $user->getFriends()->count();
        $friends_id = $user->getFriends()->pluck('id');
        $admins_id =\App\User::whereIn('type', 'admin')->get()->pluck('id');
        $pending_friendships = $user->getPendingFriendships()->where('recipient_id', '!=', $user->id)->pluck('recipient_id');
        //$accepted_requests = $user->getAcceptedFriendships();
        $denied_requests = $user->getDeniedFriendships()->pluck('recipient_id');
        $blocked_friendships = $user->getBlockedFriendships()->pluck('recipient_id');
        $pending_requests = $user->getFriendRequests()->pluck('sender_id');
        $friends_count = $user->getFriendsCount();
        $friends_of_friends = $user->getFriendsOfFriends(20);
        $friends_of_friends_id = $user->getFriendsOfFriends()->pluck('id');
        $suggestions = \App\User::where('id', '!=', $user->id)->whereNotIn('id', $friends_id)->whereNotIn('id', $admins_id)->whereNotIn('id', $denied_requests)
        ->whereNotIn('id', $blocked_friendships)->whereNotIn('id', $pending_requests)->whereNotIn('id', $pending_friendships)->whereNotIn('id', $friends_of_friends_id)->latest()->paginate(20);
        //$mutual = \App\User::where('id', '!=', $user->id)->whereNotIn('id', $friends_id)->whereNotIn('id', $denied_requests)
        //->whereNotIn('id', $blocked_friendships)->whereNotIn('id', $pending_requests)->whereNotIn('id', $pending_friendships);
        //$mutual_id =  \App\User::where('id', '!=', $user->id)->whereNotIn('id', $friends_id)->whereNotIn('id', $denied_requests)
        //->whereNotIn('id', $blocked_friendships)->whereNotIn('id', $pending_requests)->whereNotIn('id', $pending_friendships)->pluck('id');
        //$suggestion = \App\User::where('id', '!=', $user->id)->whereNotIn('id', $mutual_id)->whereNotIn('id', $friends_id)->whereNotIn('id', $denied_requests)
        //->whereNotIn('id', $blocked_friendships)->whereNotIn('id', $pending_requests)->whereNotIn('id', $pending_friendships)->get();
        //$suggestions = $mutual->concat($suggestion)->paginate(20);
        $pending_request = \App\User::whereIn('id', $pending_requests)->whereNotIn('id', $denied_requests)->count();
        return response()->json(compact('user', 'friends_count', 'suggestions', 'pending_request', 'friends_of_friends'), 201);
    }

    public function getConnects(){
        //return response()->json('success', 201);
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response()->json(['authenticated' => false],422);
        }
        $user = JWTAuth::parseToken()->authenticate();
        //$friendships = $user->getAllFriendships();
        $friends = $user->getFriends();
        //$friends_id = $user->getFriends()->pluck('id');
        //$pending_friendships = $user->getPendingFriendships()->where('recipient_id', '!=', $user->id)->pluck('recipient_id');
        //$accepted_requests = $user->getAcceptedFriendships();
        //$denied_requests = $user->getDeniedFriendships()->pluck('recipient_id');
        //$blocked_friendships = $user->getBlockedFriendships()->pluck('recipient_id');
        //$pending_requests = $user->getFriendRequests()->pluck('sender_id');
        //$friends_count = $user->getFriendsCount();
        //$all = \App\User::where('id', '!=', $user->id)->whereNotIn('id', $friends_id)->whereNotIn('id', $denied_requests)->whereNotIn('id', $blocked_friendships)->whereNotIn('id', $pending_requests)->whereNotIn('id', $pending_friendships)->get();
        //$pending_friendship = \App\User::whereIn('id', $pending_friendships)->get();
        //$pending_request = \App\User::whereIn('id', $pending_requests)->whereNotIn('id', $denied_requests)->get();
        return response()->json(compact('user', 'friends'), 201);
    }

    public function unblockFriend( $userID ){
        $user = JWTAuth::parseToken()->authenticate();
         $sender = User::where('id', '=', $userID)->first();

           /*
               If the user doesn't already like the cafe, attaches the cafe to the user's likes
           */


           if (!$user->isFriendWith($sender))
           return response()->json( ['message' => "User is not a connect"], 422 );

           if (!$user->hasBlocked($sender))
           return response()->json( ['message' => "You did not block recipent"], 422 );



           $user->unblockFriend($sender);


         return response()->json( ['message' => "User unblocked successfully"], 201 );
       }

    public function blockFriend( $userID ){
        $user = JWTAuth::parseToken()->authenticate();
         $sender = User::where('id', '=', $userID)->first();

           /*
               If the user doesn't already like the cafe, attaches the cafe to the user's likes
           */


           if (!$user->isFriendWith($sender))
           return response()->json( ['message' => "User is not a connect"], 422 );


           $user->blockFriend($sender);


         return response()->json( ['message' => "User blocked successfully"], 201 );
       }

    public function removeFriend( $userID ){
        $user = JWTAuth::parseToken()->authenticate();
         $sender = User::where('id', '=', $userID)->first();

           /*
               If the user doesn't already like the cafe, attaches the cafe to the user's likes
           */


           //if (!$user->isFriendWith($sender))
           //return response()->json( ['message' => "User is not a connect"], 422 );


           $user->unfriend($sender);


         return response()->json( ['message' => "Friend removed successfully"], 201 );
       }

    public function denyFriend( $userID ){
       $user = JWTAuth::parseToken()->authenticate();
        $sender = User::where('id', '=', $userID)->first();

          /*
              If the user doesn't already like the cafe, attaches the cafe to the user's likes
          */
          if ($user->id == $sender->id)
          return response()->json( ['message' => "You cannot connect yourself"], 422 );

          if ($user->isFriendWith($sender))
          return response()->json( ['message' => "User is already a connect"], 422 );

          if ($user->hasBlocked($sender))
          return response()->json( ['message' => "You already blocked recipent"], 422 );

          if ($user->isBlockedBy($sender))
          return response()->json( ['message' => "You are blocked by recipent"], 422 );


          $user->denyFriendRequest($sender);


        return response()->json( ['message' => "Friend request denied"], 201 );
      }

      public function acceptFriend( $userID ){
        $user = JWTAuth::parseToken()->authenticate();
         $sender = User::where('id', '=', $userID)->first();

           /*
               If the user doesn't already like the cafe, attaches the cafe to the user's likes
           */
           if ($user->id == $sender->id)
           return response()->json( ['message' => "You cannot connect yourself"], 422 );

           if ($user->isFriendWith($sender))
           return response()->json( ['message' => "User is already a connect"], 422 );

           if ($user->hasBlocked($sender))
           return response()->json( ['message' => "You already blocked recipent"], 422 );

           if ($user->isBlockedBy($sender))
           return response()->json( ['message' => "You are blocked by recipent"], 422 );


           $user->acceptFriendRequest($sender);
           $sender->notify(new FriendAccept($user, $sender));

         return response()->json( ['message' => "You are now friends"], 201 );
       }

    public function beFriend( $userID ){
        $user = JWTAuth::parseToken()->authenticate();
        $recipient = User::where('id', '=', $userID)->first();

          /*
              If the user doesn't already like the cafe, attaches the cafe to the user's likes
          */
          $admin =\App\User::where('id', $recipient->id)->where('type', 'admin')->count();
          if ($admin > 0)
          return response()->json( ['message' => "You cannot connect an admin"], 422 );

          if ($user->id == $recipient->id)
          return response()->json( ['message' => "You cannot connect yourself"], 422 );

          if ($user->isFriendWith($recipient))
          return response()->json( ['message' => "User is already a connect"], 422 );

          if ($user->hasFriendRequestFrom($recipient))
          return response()->json( ['message' => "User already sent you a request to connect"], 422 );

          if ($user->hasSentFriendRequestTo($recipient))
          return response()->json( ['message' => "You already sent a request to connect"], 422 );

          if ($user->hasBlocked($recipient))
          return response()->json( ['message' => "You already blocked recipent"], 422 );

          if ($user->isBlockedBy($recipient))
          return response()->json( ['message' => "You are blocked by recipent"], 422 );


          $user->befriend($recipient);
          $recipient->notify(new FriendRequest($recipient, $user));


        return response()->json( ['message' => "Connect request successful"], 201 );
      }

}
