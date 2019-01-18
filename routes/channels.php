<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel(sha1('rubix.-user-.{id}'), function ($user) {
    return true;
  });

//Broadcast::channel(sha1(), function ($user) {
    //return true;
  //});

Broadcast::channel('message.{id}.{user}', function ($user, $id) {
    return true;
});

Broadcast::channel('chat-room.{id}', function ($user) {
    return ['id' => $user->id, 'name' => $user->first_name];
});

Broadcast::channel('messag.{id}.{user}', function ($user, $id) {
    return true;
});

Broadcast::channel('message.{id}', function ($id) {
    return true;
});

Broadcast::channel('post.{id}', function ($user) {
    return true;
});

Broadcast::channel('comment.{id}', function ($user) {
    return true;
});

Broadcast::channel('postcomment.{id}', function ($user) {
    return true;
});

Broadcast::channel('like.{id}', function ($user) {
    return true;
});

Broadcast::channel('postlike.{id}', function ($user) {
    return true;
});

Broadcast::channel('messag.{id}', function ($id) {
    return true;
});
