<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class CustomResetPassword extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
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
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // Construir la URL directamente para evitar dependencia de la ruta nombrada
        $email = $notifiable->getEmailForPasswordReset();
        $resetUrl = url('/reset-password/' . $this->token . '?email=' . urlencode($email));

        return (new MailMessage)
                    ->subject('Restablece tu contraseña')
                    ->view('emails.password-reset', [
                        'url' => $resetUrl,
                        'user' => $notifiable,
                    ]);
    }
}
