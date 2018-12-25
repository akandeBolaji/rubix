<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\postImage;
use App\postVideo;
use App\Post;
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

    return response()->json( ['message' => $post->id,'post_comment' => true], 201 );
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

    return response()->json( ['message' => $post->id,'post_liked' => true], 201 );
  }

  public function deleteLike( $postID ){
    $user = JWTAuth::parseToken()->authenticate();
    $post = Post::where('id', '=', $postID)->first();

    $post->likes()->detach( $user->id );

    return response( ['message' => $post->id,'post_unliked' => true], 201);
  }

  public function getPosts(){
    $user = JWTAuth::parseToken()->authenticate();
    //$posts = Post::all();
    //foreach($posts as $post) {
       // $userlike = $post->likes()->where('user_id', $user->id)->count();
      //}

    //$postImage = \App\postImage;
    $post = \App\Post::with(['user.profile','images', 'comments','userlike', 'videos','comments', 'likes'])->get();
    return response()->json($post, 201);
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
         foreach($request->file('videos') as $video) {
           $destinationPath = 'post_videos';
           $videoname = $video->getClientOriginalName();
           $video->move($destinationPath, $videoname);

           $video = new postVideo([
             'path' => $videoname,
           ]);
           $post->videos()->save($video);
         }
       }
       //$images = $post->Images;
     return response()->json(['message' => 'Post Added Successfully'], 201);
     //return response()->json(compact('post','images'), 201);
     //return response()->json($post, 201);
     //$file = $request->file('files') ;
     //return response()->json($post->with('user');
}
}
