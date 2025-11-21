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
            ->subject('Welcome to E-wallet - Your Account Password')
            ->greeting('Hello ' . $this->mailData['name'] . '!')
            ->line('Welcome to E-wallet! Your account has been successfully created.')
            ->line('Here are your login credentials:')
            ->line('Username: ' . $this->mailData['username'])
            ->line('Password: ' . $this->mailData['password'])
            ->line('Please keep this information secure and do not share it with anyone.')
            ->action('Login Now', url('/login'))
            ->line('If you did not create this account, please contact our support team immediately.')
            ->line('Thank you for choosing E-wallet!');
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
