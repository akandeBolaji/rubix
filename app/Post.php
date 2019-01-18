<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class Post extends Model
{
    protected $fillable = ['text'];
    protected $appends = ['createdDate'];
    protected $table = 'posts';

    public function images() {
        return $this->hasMany(postImage::class);
    }

    public function videos() {
        return $this->hasMany(postVideo::class);
    }

    public function likes(){
        return $this->belongsToMany( 'App\User', 'users_posts_likes', 'post_id', 'user_id');
      }

    public function comments(){
        return $this->belongsToMany( 'App\User', 'users_posts_comments', 'post_id', 'user_id')->as('data')->withPivot('text');
    }

    public function friendcomments(){
        return $this->belongsToMany( 'App\User', 'users_posts_comments', 'post_id', 'user_id')->whereIn('user_id', JWTAuth::parseToken()->authenticate()->getFriends()->pluck('id'))->as('data')->withPivot('text');
    }

    public function friendlikes(){
        return $this->belongsToMany( 'App\User', 'users_posts_likes', 'post_id', 'user_id')->whereIn('user_id', JWTAuth::parseToken()->authenticate()->getFriends()->pluck('id'));
    }

    public function userlike(){
       // $user = JWTAuth::parseToken()->authenticate();
        return $this->belongsToMany( 'App\User', 'users_posts_likes', 'post_id', 'user_id')->where('user_id', JWTAuth::parseToken()->authenticate()->id);
      }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
};

