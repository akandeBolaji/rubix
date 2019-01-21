<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $appends = ['createdDate'];

    public $timestamps = true;


    public $fillable = [
        'message',
        'file',
        'image',
        'is_seen',
        'deleted_from_sender',
        'deleted_from_receiver',
        'user_id',
        'conversation_id',
    ];

    /*
     * make dynamic attribute for human readable time
     *
     * @return string
     * */
    public function getCreatedDateAttribute()
    {
        return $this->created_at->format('g:i A');

        //$date = $this->created_at;
        //$now = $date->now();

        //return $date->diffForHumans($now, true);
    }

    /*
     * make a relation between conversation model
     *
     * @return collection
     * */
    public function conversation()
    {
        return $this->belongsTo('App\Conversation');
    }

    /*
   * make a relation between user model
   *
   * @return collection
   * */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /*
   * its an alias of user relation
   *
   * @return collection
   * */
    public function sender()
    {
        return $this->user();
    }
}
