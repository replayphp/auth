<?php

namespace Replay\Auth\Notification;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification
{
    /**
     * @var string
     */
    public $token;

    /**
     * @var string
     */
    public $email;

    /**
     * @param string $token
     * @param string $email
     */
    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    /**
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ["mail"];
    }

    /**
     * @param mixed $notifiable
     *
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $link = route("replay.auth.showResetForm", ["token" => $this->token, "email" => $this->email]);

        return (new MailMessage)
            ->subject("Password Recovery")
            ->line("You are receiving this email because we received a password reset request for your account.")
            ->action("Reset Password", $link)
            ->line("If you did not request a password reset, no further action is required.");
    }
}
