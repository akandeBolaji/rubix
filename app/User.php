<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Hootlex\Friendships\Traits\Friendable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use Friendable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'ip', 'email', 'password', 'phone', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'activation_token', 'ip', 'phone', 'email', 'status', 'provider', 'provider_unique_id'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }


    public function profile()
    {
        return $this->hasOne('App\Profile');
    }


    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function accomplishments()
    {
        return $this->hasMany(Accomplishment::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments(){
        return $this->belongsToMany( 'App\User', 'users_posts_comments', 'user_id', 'post_id');
    }

    public function likes(){
        return $this->belongsToMany( 'App\Post', 'users_posts_likes', 'user_id', 'post_id');
    }

    public function messages()
    {
    return $this->hasMany(Message::class);
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    public function isNot($user)
    {
        return $this->id !== $user->id;
    }

    public function isFollowing($user)
    {
        return (bool) $this->following->where('id', $user->id)->count();
    }

    public function canFollow($user)
    {
        if(!$this->isNot($user)) {
            return false;
        }
        return !$this->isFollowing($user);
    }
}
