<?php

namespace App\Events;

use App\User;
use App\Post as Data;
use Illuminate\Database\Eloquent\Collection as Friends;
use Nahid\Talk\Messages\Message;
use Illuminate\Http\Request;
use Nahid\Talk\Facades\Talk;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PostEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
     /**
     * User that sent the message
     *
     * @var User
     */
    public $user;

    /**
     * Message details
     *
     * @var Message
     */
    public $data;

    public $friends;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Data $data, Friends $friends )
    {
        $this->user = $user;
        $this->data = $data;
        $this->friends = $friends;
    }

    public function broadcastWith()
    {
        return ['user' => $this->data->User, 'post' => $this->data, 'userlike' => $this->data->Userlike, 'images' => $this->data->Images, 'likes' => $this->data->Likes, 'comments' => $this->data->Comments, 'videos' => $this->data->Videos];
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //'order.'.$this->update->order_id
        //$userid = $this->user->id;
        //return new PrivateChannel('message.'.sha1($userid));
        foreach($this->friends as $friend) {
        return new PrivateChannel('post.'.$friend->id);
        }
    }
}

