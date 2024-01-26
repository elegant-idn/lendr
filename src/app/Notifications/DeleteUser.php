<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeleteUser extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($name, $token)
    {
        $this->name = $name;
        $this->token = $token;
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
        $deletionUrl = url('/user/confirm-deletion/' . urlencode($this->token));

        return (new MailMessage)
            ->subject('Account Deletion Confirmation')
            ->line("---")
            ->greeting("Hello, {$this->name}!")
            ->line('We received a request to delete your account. If this was not you, please ignore this email.')
            ->line('To confirm the deletion, click the button below:')
            ->action('Confirm Deletion', $deletionUrl)
            ->line('If you did not initiate this request, no further action is required.')
            ->line('Note: For security reasons, do not share this link with anyone.')
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