<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPassword extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($name, $password)
    {
        $this->name = $name;
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Your new password')
                    ->line("---")
                    ->greeting("Hello, {$this->name}!")
                    ->line('It seems you forgot your password. We are sorry to hear that!')
                    ->line('Here is your new temporary password:')
                    ->line("**{$this->password}**")
                    ->line('You can change it inside the mobile app in the account section.')
                    ->line("---");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
