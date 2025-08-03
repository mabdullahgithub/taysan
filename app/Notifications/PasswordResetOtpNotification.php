<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetOtpNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $otp;
    private $userName;
    private $email;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $otp, string $userName = 'User', string $email = '')
    {
        $this->otp = $otp;
        $this->userName = $userName;
        $this->email = $email;
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
            ->subject('Password Reset OTP - Glowzel Beauty')
            ->view('emails.password-reset-otp', [
                'otp' => $this->otp,
                'userName' => $this->userName,
                'email' => $this->email
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'otp' => $this->otp,
            'user_name' => $this->userName
        ];
    }
}
