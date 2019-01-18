<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class FriendAccept extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    protected $sender;

    protected $user;

    public function __construct($sender, $user)
    {
        $this->sender = $sender;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/conversation/'.$this->user->id);

             return (new MailMessage)
                    ->subject('New Connect')
                    ->greeting('Hello!')
                    ->line($this->user->first_name. ' '.$this->user->last_name. 'just accepted your request to connect')
                    ->line('Click on the below link to start your very first communication with the user!')
                    ->action('Start Now!', $url);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'first_name' => $this->user->first_name,
            'avatar' => $this->user->avatar,
            'last_name' => $this->user->last_name,
            'type' => 2
        ];
    }
}
