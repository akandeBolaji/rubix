<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
   // return $request->user();
//});

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login','AuthController@authenticate');
    Route::post('/logout','AuthController@logout');
    Route::post('/check','AuthController@check');
    Route::post('/register','AuthController@register');
    Route::get('/activate/{token}','AuthController@activate');
    Route::post('/password','AuthController@password');
    Route::post('/validate-password-reset','AuthController@validatePasswordReset');
    Route::post('/reset','AuthController@reset');
});

Route::group(['middleware' => ['jwt.auth', 'last_seen']], function () {
    Route::get('/auth/user','AuthController@getAuthUser');
    Route::get('/auth/userid','AuthController@getAuthUserID');
    Route::get('/user','UserController@index');
    Route::get('/search','UserController@search');
    Route::get('/user/{id}','UserController@getUser');
    Route::get('/notifications','NotificationController@getNotifications');
    Route::get('/posts','PostController@getPosts');
    Route::get('/post/{id}','PostController@getPost');
    Route::post('/posts','PostController@newPost');
    Route::get('/message/{id}','MessageController@getMessage');
    Route::get('/message/{id}/{page}','MessageController@getMessage');
    Route::get('/thread','MessageController@getThreads');
    Route::post('/message','MessageController@newMessage');
    Route::post('/message-file','MessageController@newFile');
    Route::post('/message-image','MessageController@newImage');
    Route::delete('/message/{id}', 'MessageController@deleteMessage');
    Route::get('/posts/{id}','PostController@getPost');
    Route::post('/posts/{id}/like', 'PostController@postLike');
    Route::get('/sent','ConnectController@getSent');
    Route::get('/received','ConnectController@getReceived');
    Route::get('/suggestions','ConnectController@getSuggestions');
    Route::get('/connects','ConnectController@getConnects');
    Route::post('/connect/{id}/befriend', 'ConnectController@beFriend');
    Route::post('/connect/{id}/acceptfriend', 'ConnectController@acceptFriend');
    Route::post('/connect/{id}/denyfriend', 'ConnectController@denyFriend');
    Route::post('/connect/{id}/removefriend', 'ConnectController@removeFriend');
    Route::post('/connect/{id}/blockfriend', 'ConnectController@blockFriend');
    Route::post('/connect/{id}/unblockfriend', 'ConnectController@unblockFriend');
    Route::post('/posts/comment', 'PostController@postComment');
    Route::delete('/posts/{id}/like', 'PostController@deleteLike');
    Route::post('/user/change-password','AuthController@changePassword');
    Route::post('/user/update-profile','UserController@updateProfile');
    Route::post('/user/remove-skill/{id}','UserController@removeSkill');
    Route::post('/user/remove-experience/{id}','UserController@removeExperience');
    Route::post('/user/remove-accomplishment/{id}','UserController@removeAccomplishment');
    Route::post('/user/update-avatar','UserController@updateAvatar');
    Route::post('/user/remove-avatar','UserController@removeAvatar');
    Route::delete('/user/{id}','UserController@destroy');
      Route::delete('/user/{id}','UserController@destroy');
      Route::get('/user/dashboard','UserController@dashboard');
  });
