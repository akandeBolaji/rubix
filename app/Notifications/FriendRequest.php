<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class FriendRequest extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    protected $recipient;

    protected $user;

    public function __construct($recipient, $user)
    {
        $this->recipient = $recipient;
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
        $url = url('/received/');

             return (new MailMessage)
                    ->subject('New Connect Request')
                    ->greeting('Hello!')
                    ->line($this->user->first_name. ' '.$this->user->last_name. ' just sent you a request to connect')
                    ->line('Click on the below link to accept or reject the request')
                    ->action('Go!', $url);
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
            'last_name' => $this->user->last_name,
            'avatar' => $this->user->avatar,
            'type' => 1
        ];
    }
}
