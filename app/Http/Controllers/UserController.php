<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use JWTAuth;

class UserController extends Controller
{

    protected $avatar_path = 'images/users/';

	public function index(){
		$users = \App\User::with('profile');

		if(request()->has('first_name'))
            $query->whereHas('profile',function($q) use ($request){
                $q->where('first_name','like','%'.request('first_name').'%');
            });

		if(request()->has('last_name'))
            $query->whereHas('profile',function($q) use ($request){
                $q->where('last_name','like','%'.request('last_name').'%');
            });

		if(request()->has('email'))
			$users->where('email','like','%'.request('email').'%');

        if(request()->has('status'))
            $users->whereStatus(request('status'));

        if(request('sortBy') == 'first_name' || request('sortBy') == 'last_name')
            $users->with(['profile' => function ($q) {
              $q->orderBy(request('sortBy'), request('order'));
            }]);
        else
            $users->orderBy(request('sortBy'),request('order'));

		return $users->paginate(request('pageLength'));
    }

    public function search(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if ($request->keywords == null){
            return response()->json([]);
        }
        //$query = $request->query('query');

        $user = \App\User::whereRaw("CONCAT(first_name, ' ', last_name) LIKE '%$request->keywords%'")->
        orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE '%$request->keywords%'")->get();
        $users = \App\User::whereRaw("CONCAT(first_name, ' ', last_name) LIKE '%$request->keywords%'")->
        orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE '%$request->keywords%'")->
        paginate(20);
        //whereRaw('concat(\'first_name\', \'last_name\')', 'LIKE', '%' . $request->keywords . '%');

        return response()->json($users);
    }

    public function getUser($id){
        $auth = JWTAuth::parseToken()->authenticate();
        $user = \App\User::find($id);
        if($auth == $user){
            $status = 'user';
            $friends_count = $user->getFriendsCount();
            $profile = $user->Profile;
            $posts = $user->Post;
            $skill = $user->Skills;
            $experience = $user->Experiences;
            $accomplishment = $user->Accomplishments;
            return response()->json(compact('user', 'friends_count', 'status'), 201);
        }
        $user->view = $user->view + 1;
        $user->save();
        if($auth != $user && $auth->isFriendWith($user)){
            $status = 'friends';
            $friends_count = $user->getFriendsCount();
            $profile = $user->Profile;
            $posts = $user->Post;
            $skill = $user->Skills;
            $experience = $user->Experiences;
            $accomplishment = $user->Accomplishments;
            return response()->json(compact('user', 'friends_count', 'status'), 201);
        }
        if ($auth->hasFriendRequestFrom($user)) {
            $status = 'accept';
            $friends_count = $user->getFriendsCount();
            $profile = $user->Profile;
            $posts = $user->Post;
            $skill = $user->Skills;
            $experience = $user->Experiences;
            $accomplishment = $user->Accomplishments;
            return response()->json(compact('user', 'friends_count', 'status'), 201);
        }

        if ($auth->hasSentFriendRequestTo($user)) {
            $status = 'pending';
            $friends_count = $user->getFriendsCount();
            $profile = $user->Profile;
            $posts = $user->Post;
            $skill = $user->Skills;
            $experience = $user->Experiences;
            $accomplishment = $user->Accomplishments;
            return response()->json(compact('user', 'friends_count', 'status'), 201);
        }
        else {
            $status = 'send';
            $friends_count = $user->getFriendsCount();
            $profile = $user->Profile;
            $posts = $user->Post;
            $skill = $user->Skills;
            $experience = $user->Experiences;
            $accomplishment = $user->Accomplishments;
            return response()->json(compact('user', 'friends_count', 'status'), 201);
        }
    }

    public function updateProfile(Request $request){

        $validation = Validator::make($request->all(),[
            //'first_name' => 'required|min:2',
            //'last_name' => 'required|min:2',
            //'profileData.date_of_birth' => 'required|date_format:Y-m-d',
            //'profileData.gender' => 'required|in:male,female',
            //'profileData.headline' => 'required|min:24'
        ]);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first()],422);
        //return response()->json($request);

        $user = JWTAuth::parseToken()->authenticate();
        //$profile = new \App\Profile;
        $profile = $user->Profile;
        $skills = $user->Skills;
        //$experiences = $user->Experiences;
       // $accomplishments = $user->Accomplishments;

        //$profile->first_name = request('first_name');
        //$profile->last_name = request('last_name');
        if ($request->input('profileData.location')){
        $profile->location = $request->input('profileData.location');
        };
        if ($request->input('profileData.phone')){
        $profile->phone = $request->input('profileData.phone');
        };
        if ($request->input('profileData.headline')){
        $profile->headline = $request->input('profileData.headline');
        };
        if ($request->input('profileData.date_of_birth')){
        $profile->date_of_birth = $request->input('profileData.date_of_birth');
        };
        if ($request->input('profileData.gender')){
        $profile->gender = $request->input('profileData.gender');
        };
        if ($request->input('profileData.twitter_profile')){
        $profile->twitter_profile = $request->input('profileData.twitter_profile');
        };
        if ($request->input('profileData.linkedin_profile')){
        $profile->linkedin_profile = $request->input('profileData.linkedin_profile');
        };
        if ($request->input('profileData.facebook_profile')){
        $profile->facebook_profile = $request->input('profileData.facebook_profile');
        };
        if ($request->input('profileData.google_plus_profile')){
        $profile->google_plus_profile = $request->input('profileData.google_plus_profile');
        };
        //$user->profile()->save($profile);
        $profile->save();

            if (request('skillData')) {
            foreach(request('skillData') as $skill) {
            $newSkill = new \App\Skill;
            $newSkill->description = $skill;
            $user->skills()->save($newSkill);
            };
        };

            if (request('experienceData')) {
            foreach(request('experienceData') as $experience) {
            $newExperience = new \App\Experience;
            $newExperience->name = $experience['name'];
            $newExperience->location = $experience['location'];
            $newExperience->start_date = $experience['start_date'];
            $newExperience->end_date = $experience['end_date'];
            $user->experiences()->save($newExperience);
        };
        //return response()->json('true');
    };

    if (request('accomplishmentData')) {
        $accomplishmentsarray = request('accomplishment');
        foreach(request('accomplishmentData') as $accomplishment) {
            $newAccomplishment = new \App\Accomplishment;
            $newAccomplishment->name = $accomplishment['name'];
            $newAccomplishment->description = $accomplishment['description'];
            $newAccomplishment->links = $accomplishment['links'];
            $newAccomplishment->certificates = $accomplishment['certificates'];
            $user->accomplishments()->save($newAccomplishment);
        };
    };

        return response()->json(['message' => 'Your profile has been updated!']);

        //return response()->json(['message' => 'Your profile has been updated!','user' => $user,]);
    }

    public function updateAvatar(Request $request){
        $validation = Validator::make($request->all(), [
            'avatar' => 'required|image'
        ]);

        if ($validation->fails())
            return response()->json(['message' => $validation->messages()->first()],422);

        $user = JWTAuth::parseToken()->authenticate();
        //$profile = $user->Profile;

        if($user->avatar && \File::exists($this->avatar_path.$user->avatar))
            \File::delete($this->avatar_path.$user->avatar);

        $extension = $request->file('avatar')->getClientOriginalExtension();
        $filename = uniqid();
        $file = $request->file('avatar')->move($this->avatar_path, $filename.".".$extension);
        //$img = \Image::make($this->avatar_path.$filename.".".$extension);
        //$img->resize(200, null, function ($constraint) {
           // $constraint->aspectRatio();
        //});
        //$img->save($this->avatar_path.$filename.".".$extension);
        $user->avatar = $filename.".".$extension;
        $user->save();

        return response()->json(['message' => 'Avatar updated!']);
    }

    public function removeAvatar(Request $request){

        $user = JWTAuth::parseToken()->authenticate();

        //$profile = $user->Profile;
        if(!$user->avatar)
            return response()->json(['message' => 'No avatar uploaded!'],422);

        if(\File::exists($this->avatar_path.$user->avatar))
            \File::delete($this->avatar_path.$user->avatar);

        $user->avatar = null;
        $user->save();

        return response()->json(['message' => 'Avatar removed!']);
    }

    public function removeSkill(Request $request, $id){

        $skill = \App\Skill::find($id);

        if(!$skill)
        return response()->json(['message' => 'Could not find skill!'],422);

        $skill->delete();

        return response()->json(['success','message' => 'Skill deleted!']);
    }

    public function removeExperience(Request $request, $id){

        $experience = \App\Experience::find($id);

        if(!$experience)
        return response()->json(['message' => 'Could not find experience!'],422);

        $experience->delete();

        return response()->json(['success','message' => 'Experience deleted!']);
    }

    public function removeAccomplishment(Request $request, $id){

        $accomplishment = \App\Accomplishment::find($id);

        if(!$accomplishment)
        return response()->json(['message' => 'Could not find accomplishment!'],422);

        $accomplishment->delete();

        return response()->json(['success','message' => 'Accomplishment deleted!']);
    }

    public function destroy(Request $request, $id){
        if(env('IS_DEMO'))
            return response()->json(['message' => 'You are not allowed to perform this action in this mode.'],422);

        $user = \App\User::find($id);

        if(!$user)
            return response()->json(['message' => 'Couldnot find user!'],422);

        if($user->avatar && \File::exists($this->avatar_path.$user->avatar))
            \File::delete($this->avatar_path.$user->avatar);

        $user->delete();

        return response()->json(['success','message' => 'User deleted!']);
    }

    public function dashboard(){
      $users_count = \App\User::count();
      $tasks_count = \App\Task::count();
      $recent_incomplete_tasks = \App\Task::whereStatus(0)->orderBy('due_date','desc')->limit(5)->get();
      return response()->json(compact('users_count','tasks_count','recent_incomplete_tasks'));
    }
}
