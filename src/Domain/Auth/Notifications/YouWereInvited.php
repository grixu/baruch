<?php

namespace Domain\Auth\Notifications;

use Domain\Auth\Models\Invitation;
use Domain\Auth\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use function url;

class YouWereInvited extends Notification
{
    use Queueable;

    public function __construct(public Invitation $invitation, public User $invitedBy)
    {
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
