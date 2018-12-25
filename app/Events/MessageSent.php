<?php

namespace App\Events;

use App\User;
use App\User as Receiver;
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

class MessageSent implements ShouldBroadcast
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
    public $message;

    public $receiver;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Message $message, Receiver $receiver)
    {
        $this->user = $user;
        $this->message = $message;
        $this->receiver = $receiver;
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
        return new PrivateChannel('message.'.$this->user->id.'.'.$this->receiver->id);
    }
}
