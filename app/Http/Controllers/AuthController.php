<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Contracts\JWTSubject as JWTSubject;
use Validator;
use App\User;
use Nahid\Talk\Facades\Talk;
use App\Notifications\Activation;
use App\Notifications\Activated;
use App\Notifications\PasswordReset;
use App\Notifications\PasswordResetted;

class AuthController extends Controller
{
    function __construct()
    {
        //$user = ;
        Talk::setAuthUserId(JWTAuth::parseToken()->authenticate()->id);
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


         return response()->json( ['message' => "You are now friends"], 201 );
       }

    public function beFriend( $userID ){
        $user = JWTAuth::parseToken()->authenticate();
        $recipient = User::where('id', '=', $userID)->first();

          /*
              If the user doesn't already like the cafe, attaches the cafe to the user's likes
          */
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


        return response()->json( ['message' => "Connect request successful"], 201 );
      }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'Invalid Credentials! Please try again.'], 422);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'This is something wrong. Please try again!'], 500);
        }

        $user = \App\User::whereEmail(request('email'))->first();

        if($user->status == 'pending_activation')
            return response()->json(['message' => 'Your account hasn\'t been activated. Please check your email & activate account.'], 422);

        if($user->status == 'banned')
            return response()->json(['message' => 'Your account is banned. Please contact system administrator.'], 422);

        if($user->status != 'activated')
            return response()->json(['message' => 'There is something wrong with your account. Please contact system administrator.'], 422);

         //$authuser = JWTAuth::user();

        return response()->json(['message' => 'You are successfully logged in!','token' => $token]);
    }

    public function getAuthUser(){
        //return response()->json('success', 201);
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response()->json(['authenticated' => false],422);
        }
        $user = JWTAuth::parseToken()->authenticate();
        //$friendships = $user->getAllFriendships();
        $friends = $user->getFriends();
        $friends_id = $user->getFriends()->pluck('id');
        $pending_friendships = $user->getPendingFriendships()->where('recipient_id', '!=', $user->id)->pluck('recipient_id');
        $accepted_requests = $user->getAcceptedFriendships();
        $denied_requests = $user->getDeniedFriendships()->pluck('recipient_id');
        $blocked_friendships = $user->getBlockedFriendships()->pluck('recipient_id');
        $pending_requests = $user->getFriendRequests()->pluck('sender_id');
        $friends_count = $user->getFriendsCount();
        $all = \App\User::where('id', '!=', $user->id)->whereNotIn('id', $friends_id)->whereNotIn('id', $denied_requests)->whereNotIn('id', $blocked_friendships)->whereNotIn('id', $pending_requests)->whereNotIn('id', $pending_friendships)->get();
        $pending_friendship = \App\User::whereIn('id', $pending_friendships)->get();
        $pending_request = \App\User::whereIn('id', $pending_requests)->whereNotIn('id', $denied_requests)->get();
        $profile = $user->Profile;
        $threads = Talk::threads();
        $skill = $user->Skills;
        $experience = $user->Experiences;
        $accomplishment = $user->Accomplishments;
        return response()->json(compact('user', 'threads', 'friends', 'pending_friendship', 'pending_request', 'friends_count', 'all', 'profile', 'skill', 'experience', 'accomplishment'), 201);
    }

    public function check()
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response(['authenticated' => false]);
        }

        return response(['authenticated' => true]);
    }

    public function logout()
    {

        try {
            $token = JWTAuth::getToken();

            if ($token) {
                JWTAuth::invalidate($token);
            }

        } catch (JWTException $e) {
            return response()->json($e->getMessage(), 500);
        }

        return response()->json(['message' => 'You are successfully logged out!']);
    }

    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'last_name' => 'required',
            'first_name' => 'required',
            'age' => 'required',
            'headline' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password'
        ]);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first()],422);

        $user = \App\User::create([
            'phone' => request('phone'),
            'ip' => request()->ip(),
            'email' => request('email'),
            'status' => 'pending_activation',
            'password' => bcrypt(request('password'))
        ]);

        do {
            $activation_token = str_random(64);
        } while ( \DB::table('users')->where('activation_token',$activation_token)->exists());
        $user->activation_token = $activation_token;
        $user->save();
        $profile = new \App\Profile;
        $profile->email = request('email');
        $profile->gender = request('gender');
        $profile->first_name = request('first_name');
        $profile->headline = request('headline');
        $profile->last_name = request('last_name');
        $profile->age = request('age');
        $profile->phone = request('phone');
        $user->profile()->save($profile);
        $user->notify(new Activation($user));

        return response()->json(['message' => 'You have been registered successfully. Please check your email for activation!']);
    }

    public function activate($activation_token){
        $user = \App\User::whereActivationToken($activation_token)->first();

        if(!$user)
            return response()->json(['message' => 'Invalid activation token!'],422);

        if($user->status == 'activated')
            return response()->json(['message' => 'Your account has already been activated!'],422);

        if($user->status != 'pending_activation')
            return response()->json(['message' => 'Invalid activation token!'],422);

        $user->status = 'activated';
        $user->save();
        $user->notify(new Activated($user));

        return response()->json(['message' => 'Your account has been activated!']);
    }

    public function password(Request $request){

        $validation = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first()],422);

        $user = \App\User::whereEmail(request('email'))->first();

        if(!$user)
            return response()->json(['message' => 'We couldn\'t found any user with this email. Please try again!'],422);

        $token = str_random(64);;
        \DB::table('password_resets')->insert([
            'email' => request('email'),
            'token' => $token
        ]);
        $user->notify(new PasswordReset($user,$token));

        return response()->json(['message' => 'We have sent a reminder email. Please check your inbox!']);
    }

    public function validatePasswordReset(Request $request){
        $validate_password_request = \DB::table('password_resets')->where('token','=',request('token'))->first();

        if(!$validate_password_request)
            return response()->json(['message' => 'Invalid password reset token!'],422);

        if(date("Y-m-d H:i:s", strtotime($validate_password_request->created_at . "+30 minutes")) < date('Y-m-d H:i:s'))
            return response()->json(['message' => 'Password reset token is expired. Please request reset password again!'],422);

        return response()->json(['message' => '']);
    }

    public function reset(Request $request){

        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password'
        ]);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first()],422);

        $user = \App\User::whereEmail(request('email'))->first();

        if(!$user)
            return response()->json(['message' => 'We couldn\'t found any user with this email. Please try again!'],422);

        $validate_password_request = \DB::table('password_resets')->where('email','=',request('email'))->where('token','=',request('token'))->first();

        if(!$validate_password_request)
            return response()->json(['message' => 'Invalid password reset token!'],422);

        if(date("Y-m-d H:i:s", strtotime($validate_password_request->created_at . "+30 minutes")) < date('Y-m-d H:i:s'))
            return response()->json(['message' => 'Password reset token is expired. Please request reset password again!'],422);

        $user->password = bcrypt(request('password'));
        $user->save();

        //$user->notify(new PasswordResetted($user));

        return response()->json(['message' => 'Your password has been reset. Please login again!']);
    }

    public function changePassword(Request $request){
        if(env('IS_DEMO'))
            return response()->json(['message' => 'You are not allowed to perform this action in this mode.'],422);

        $validation = Validator::make($request->all(),[
            'current_password' => 'required',
            'new_password' => 'required|confirmed|different:current_password|min:6',
            'new_password_confirmation' => 'required|same:new_password'
        ]);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first()],422);

        $user = JWTAuth::parseToken()->authenticate();

        if(!\Hash::check(request('current_password'),$user->password))
            return response()->json(['message' => 'Old password does not match! Please try again!'],422);

        $user->password = bcrypt(request('new_password'));
        $user->save();

        return response()->json(['message' => 'Your password has been changed successfully!']);
    }
}
