<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\postImage;
use App\postVideo;
use App\Post;
use App\Events\PostEvent;
use App\Events\CommentEvent;
use App\Events\LikeEvent;
use App\Events\ShareEvent;
use App\Events\UnlikeEvent;
use App\Events\Comment;
use App\Events\Like;
use App\Events\Share;
use App\Events\Unlike;
use Validator;


class PostController extends Controller
{
    /*
  |-------------------------------------------------------------------------------
  | Get All post
  |-------------------------------------------------------------------------------
  | URL:            /api/v1/cafes
  | Method:         GET
  | Description:    Gets all of the cafes in the application
  */
  public function postComment( Request $request ){
    $user = JWTAuth::parseToken()->authenticate();
    $validation = Validator::make($request->all(), [
        'comment' => 'required',
    ]);
    //return response()->json(['message' => $request->all()],422);

    if($validation->fails())
        return response()->json(['message' => $validation->messages()->first()],422);

    $post = Post::where('id', '=', $request->post_id)->first();

      /*
          If the user doesn't already like the cafe, attaches the cafe to the user's likes
      */
      $post->comments()->attach( $user->id, [
          'text' => $request->comment,
          'created_at'    => date('Y-m-d H:i:s'),
          'updated_at'    => date('Y-m-d H:i:s')
    ] );
    $data = $post;
    $friends = $user->getFriends();

    if ($friends->count() != 0) {
    broadcast(new CommentEvent($user, $data, $friends));
    }
    broadcast(new Comment($user, $data))->toOthers();
    return response()->json( ['message' => $post->id,'post_comment' => true], 201 );
  }


  public function postShare( $postID ){
    $user = JWTAuth::parseToken()->authenticate();
    $post = Post::where('id', '=', $postID)->first();

      /*
          If the user doesn't already like the cafe, attaches the cafe to the user's likes
      */
      $post->shares()->attach( $user->id, [
          'created_at'    => date('Y-m-d H:i:s'),
          'updated_at'    => date('Y-m-d H:i:s')
    ] );
    $data = $post;
    $friends = $user->getFriends();

    if ($friends->count() != 0) {
    broadcast(new ShareEvent($user, $data, $friends));
    }
    broadcast(new Share($user, $data))->toOthers();
    return response()->json( ['message' => $post->id,'post_shared' => true], 201 );
  }

  public function postLike( $postID ){
    $user = JWTAuth::parseToken()->authenticate();
    $post = Post::where('id', '=', $postID)->first();

      /*
          If the user doesn't already like the cafe, attaches the cafe to the user's likes
      */
      $post->likes()->attach( $user->id, [
          'created_at'    => date('Y-m-d H:i:s'),
          'updated_at'    => date('Y-m-d H:i:s')
    ] );
    $data = $post;
    $friends = $user->getFriends();

    if ($friends->count() != 0) {
    broadcast(new LikeEvent($user, $data, $friends));
    }
    broadcast(new Like($user, $data))->toOthers();
    return response()->json( ['message' => $post->id,'post_liked' => true], 201 );
  }

  public function deleteLike( $postID ){
    $user = JWTAuth::parseToken()->authenticate();
    $post = Post::where('id', '=', $postID)->first();

    $post->likes()->detach( $user->id );
    $data = $post;
    $friends = $user->getFriends();

    if ($friends->count() != 0) {
    broadcast(new UnlikeEvent($user, $data, $friends));
    }
    broadcast(new Unlike($user, $data))->toOthers();
    return response( ['message' => $post->id,'post_unliked' => true], 201);
  }

  public function getPosts(){
    $user = JWTAuth::parseToken()->authenticate();
    $adminpost = Post::where('type', 'admin')->with(['user','images', 'comments','userlike', 'usershare', 'usercomment', 'videos', 'likes'])->latest()->paginate(10);
    $adminid = Post::where('type', 'admin')->with(['user','images', 'comments','userlike', 'usershare', 'usercomment', 'videos', 'likes'])->pluck('id');
    $friendspost = Post::whereIn('user_id', $user->getFriends()->pluck('id'))->with(['user','images', 'comments','userlike', 'usershare', 'usercomment', 'videos', 'likes'])->latest()->paginate(10);
    $friendsid = Post::whereIn('user_id', $user->getFriends()->pluck('id'))->with(['user','images', 'comments','userlike', 'usershare', 'usercomment', 'videos', 'likes'])->pluck('id');
    $userpost = Post::where('user_id', $user->id)->with(['user','images', 'comments','userlike', 'usershare', 'usercomment', 'videos', 'likes'])->latest()->paginate(10);
    $userid = Post::where('user_id', $user->id)->with(['user','images', 'comments','userlike', 'usershare', 'usercomment', 'videos', 'likes'])->pluck('id');
    $friendcomments = Post::whereNotIn('user_id', $user->getFriends()->pluck('id'))->whereNotIn('id', $adminid)->whereNotIn('id', $friendsid)->whereNotIn('id', $userid)
    ->whereHas('friendcomments')->with(['user','images', 'comments','userlike', 'usershare', 'usercomment', 'videos', 'likes', 'friendcomments'])->latest()->paginate(10);
    $friendcommentsid = Post::whereNotIn('user_id', $user->getFriends()->pluck('id'))
    ->whereHas('friendcomments')->with(['user','images', 'comments','userlike', 'usershare', 'usercomment', 'videos', 'likes', 'friendcomments'])->pluck('id');
    $friendlikes = Post::whereNotIn('user_id', $user->getFriends()->pluck('id'))->whereNotIn('id', $adminid)->whereNotIn('id', $friendsid)->whereNotIn('id', $userid)->whereNotIn('id', $friendcommentsid)
    ->whereHas('friendlikes')->with(['user','images', 'comments','userlike', 'usershare', 'usercomment', 'videos', 'likes', 'friendlikes'])->latest()->paginate(10);
    $friendshares = Post::whereNotIn('user_id', $user->getFriends()->pluck('id'))
    ->whereHas('friendshares')->with(['user','images', 'comments','userlike', 'usershare', 'usercomment', 'videos', 'likes', 'friendshares'])->latest()->paginate(10);
    //$post = Post::with(['user','images', 'comments','userlike', 'videos', 'likes'])->latest()->paginate(10);
    //return response()->json(['post' => $post, 'user' => $user], 201);
    return response()->json(compact('userpost', 'friendcomments', 'adminpost', 'friendspost', 'friendshares', 'friendlikes', 'user'), 201);
}

/*
|-------------------------------------------------------------------------------
| Get An Individual Cafe
|-------------------------------------------------------------------------------
| URL:            /api/posts/{id}
| Method:         GET
| Description:    Gets an individual cafe
| Parameters:
|   $id   -> ID of the cafe we are retrieving
*/
public function getPost( $id ){

    $auth = JWTAuth::parseToken()->authenticate();
    $post = Post::find($id);
    $user = $post->User;
    $images = $post->Images;
    $comments = $post->Comments;
    $userlike = $post->Userlike;
    $usershare = $post->Usershare;
    $videos = $post->Videos;
    $likes = $post->Likes;

    //$post = $post->with(['user','images', 'comments','userlike', 'videos', 'likes'])->get();
    return response()->json(compact('post', 'auth'), 201);
    //return response()->json(compact('post', 'auth', 'user', 'images', 'comments', 'userlike', 'videos', 'likes'), 201);
}
 /*
  |-------------------------------------------------------------------------------
  | Adds a New post
  |-------------------------------------------------------------------------------
  | URL:            /api/post
  | Method:         POST
  | Description:    Adds a new post to the application
  */
 public function newPost(Request $request){
    $validation = Validator::make($request->all(), [
        'text' => 'required',
        'videos' => 'mimes:mp4,3gp|max:25000'
    ]);
    //return response()->json(['message' => $request->all()],422);

    if($validation->fails())
        return response()->json(['message' => $validation->messages()->first()],422);
     $user = JWTAuth::parseToken()->authenticate();
     $post = new Post();
    // return response()->json($request->file('files[0]'));
   // return response()->json($request->all());
    // $post->fill($request->all());
     $post->text = $request->text;
     $post->user_id = $user->id;
     $post->save();

     if ($request->hasFile('files')){
      //return response()->json(["message" => "file detected"]);
       foreach($request->file('files') as $file) {
         $destinationPath = 'post_images';
         $filename = $file->getClientOriginalName();
         $file->move($destinationPath, $filename);

         $file = new postImage([
           'path' => $filename,
         ]);
         $post->images()->save($file);
       }
     }
     if ($request->hasFile('videos')){
        //return response()->json(["message" => "video detected"]);
        $video = $request->file('videos');

           $destinationPath = 'post_videos';
           $videoname = $video->getClientOriginalName();
           $video->move($destinationPath, $videoname);

           $video = new postVideo([
             'path' => $videoname,
           ]);
           $post->videos()->save($video);
         }
         $data = $post;

         $friends = $user->getFriends();
       //$images = $post->Images;
       if ($friends->count() != 0) {
       broadcast(new PostEvent($user, $data, $friends));
       }
     return response()->json(['message' => 'Post Added Successfully'], 201);
     //return response()->json(compact('post','images'), 201);
     //return response()->json($post, 201);
     //$file = $request->file('files') ;
     //return response()->json($post->with('user');
}
}
