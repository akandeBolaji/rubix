<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Activation extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    protected $user;

    public function __construct($user)
    {
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/auth/'.$this->user->activation_token.'/activate');

             //return (new MailMessage)
               //     ->subject('Account Activation')
                 //   ->greeting('Hello!')
                   // ->line('Thank you for registering an account with us.')
                   // ->line('Click on the below link to verify your email!')
                    //->action('Verify now!', $url)
                    //->line('Thank you for using our application!! Start Predicting!!');

            return (new MailMessage)
            ->subject('Account Activation')
            ->markdown('mail.account.activation', ['url'=> $url]);


            //return (new MailMessage)->view(
               // 'emails.activation', ['url' => $url]
           // );
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
            //
        ];
    }
}
