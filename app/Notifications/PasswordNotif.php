<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordNotif extends Notification
{
    use Queueable;

    public array $mailData;

    public function __construct(array $mailData)
    {
        $this->mailData = $mailData;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Welcome to PayNoy - Your Account Password')
            ->markdown('emails.password_notif', ['mailData' => $this->mailData]);
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
