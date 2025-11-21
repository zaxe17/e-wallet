<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordNotif extends Notification implements ShouldQueue
{
    use Queueable;

    protected $password;
    protected $username;
    protected $fullName;

    public function __construct($password, $username, $fullName)
    {
        $this->password = $password;
        $this->username = $username;
        $this->fullName = $fullName;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Welcome to E-wallet - Your Account Password')
            ->greeting('Hello ' . $this->fullName . '!')
            ->line('Welcome to E-wallet! Your account has been successfully created.')
            ->line('Here are your login credentials:')
            ->line('**Username:** ' . $this->username)
            ->line('**Password:** ' . $this->password)
            ->line('Please keep this information secure and do not share it with anyone.')
            ->action('Login Now', url('/login'))
            ->line('If you did not create this account, please contact our support team immediately.')
            ->line('Thank you for choosing E-wallet!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'username' => $this->username,
            'full_name' => $this->fullName,
        ];
    }
}