<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use JWTGuard;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Contracts\JWTSubject as JWTSubject;
use Validator;
use App\User;
use Nahid\Talk\Facades\Talk;
use App\Notifications\Activation;
use App\Notifications\Activated;
use App\Notifications\FriendRequest;
use App\Notifications\FriendAccept;
use App\Notifications\PasswordReset;
use App\Notifications\PasswordResetted;

class AuthController extends Controller
{
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
        //$post = $post->with(['user','images', 'comments','userlike', 'videos', 'likes'])->get();
        $friends_count = $user->getFriendsCount();
        $profile = $user->Profile;
        $skill = $user->Skills;
        $posts = $user->Posts;
        $comments = $user->Comments;
        $likes = $user->Likes;
        $experience = $user->Experiences;
        $accomplishment = $user->Accomplishments;
        return response()->json(compact('user', 'friends_count'), 201);
    }

    public function getAuthUserId(){
        //return response()->json('success', 201);
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response()->json(['authenticated' => false],422);
        }
        $user = JWTAuth::parseToken()->authenticate();
        if ($user->login == 0){
        $body = "Hello <b>".JWTAuth::parseToken()->authenticate()->first_name. " ".JWTAuth::parseToken()->authenticate()->last_name. ",</b><br/>Welcome to Rubix Music Community - The First online community for music makers and lovers. Our Basic functionalities
        allows you to <i>search users, check a user profile, edit your profile, send connect requests, accept or decline connect requests, block connects, message connects, view suggestions of people you may know based on
        mutual connects and location all in real time. Your feeds lets you view posts, likes, comments and shares by connect in real time, you can create a post, like a post, comment or share a post
        and its all broadcasted in real time</i>. We would leave you to explore other functionalities and hope you have fun while doing that.<br/><b>N.B: Replies to this message would not be delivered.<b> <br/>Regards, <b>Rubix team</b.." ;
        $conversation = \App\Conversation::create([
            'user_one' => \App\User::find(1)->id,
            'user_two' => JWTAuth::parseToken()->authenticate()->id,
            'status' => 1,
        ]);
        $message = \App\Message::create([
            'message' => $body,
            'conversation_id' => $conversation->id,
            'user_id' => \App\User::find(1)->id,
            'is_seen' => 0,
        ]);
        $user->login = 1;
        $user->save();
        }
        $threads = Talk::user(auth()->user()->id)->threads();
        $unread = 0;
        if ($threads){
            foreach($threads as $thread) {
                if ($user->id != $thread->thread->sender->id && $thread->thread->is_seen == 0){
                $unread = $unread + $thread->unread;
                }
            }
        }
        $user = JWTAuth::parseToken()->authenticate()->id;
        return response()->json(compact('user', 'unread'), 201);
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
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'headline' => request('headline'),
            'password' => bcrypt(request('password')),
        ]);

        do {
            $activation_token = str_random(64);
        } while ( \DB::table('users')->where('activation_token',$activation_token)->exists());
        $user->activation_token = $activation_token;
        $user->status = 'activated';
        $user->save();
        $profile = new \App\Profile;
        $profile->email = request('email');
        $profile->gender = request('gender');
        //$profile->first_name = request('first_name');
        //$profile->last_name = request('last_name');
        $profile->age = request('age');
        $profile->phone = request('phone');
        $user->profile()->save($profile);
       // $credentials = $request->only('email', 'password');
        //$token = JWTGuard::tokenById($user->id);
        //$token = JWTAuth::setToken($token);
        //JWTAuth::authenticate($token);
        //Talk::user(auth()->user()->id)->sendMessageByUserId($user->id, $body);
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'Invalid Credentials! Please try again.'], 422);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'This is something wrong. Please try again!'], 500);
        }
        // $user->notify(new Activation($user));

        return response()->json(['message' => 'You have been registered successfully. Please check your email for activation!','token' => $token]);
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
