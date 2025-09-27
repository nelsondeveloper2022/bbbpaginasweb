<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class LicenseExpirationReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $daysRemaining;
    public $expirationDate;
    public $licenseType;
    public $adminLoginUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, int $daysRemaining, string $licenseType = 'trial')
    {
        $this->user = $user;
        $this->daysRemaining = $daysRemaining;
        $this->licenseType = $licenseType;
        
        // Determinar la fecha de expiración según el tipo de licencia
        if ($licenseType === 'subscription' && $user->subscription_ends_at) {
            $this->expirationDate = $user->subscription_ends_at;
        } else {
            $this->expirationDate = $user->trial_ends_at;
        }
        
        // URL del panel administrativo para renovación
        $this->adminLoginUrl = config('app.url') . '/login';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subjectMessage = match($this->daysRemaining) {
            5 => 'Tu licencia expira en 5 días - BBB Páginas Web',
            3 => 'Tu licencia expira en 3 días - BBB Páginas Web', 
            1 => '¡URGENTE! Tu licencia expira mañana - BBB Páginas Web',
            0 => 'Tu licencia expira hoy - BBB Páginas Web',
            default => "Tu licencia expira en {$this->daysRemaining} días - BBB Páginas Web"
        };

        return new Envelope(
            subject: $subjectMessage,
            from: new Address(
                config('app.support.email'),
                'BBB Páginas Web'
            ),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.license-expiration-reminder',
            with: [
                'user' => $this->user,
                'daysRemaining' => $this->daysRemaining,
                'expirationDate' => $this->expirationDate,
                'licenseType' => $this->licenseType,
                'adminLoginUrl' => $this->adminLoginUrl,
                'supportEmail' => config('app.support.email'),
                'supportWhatsApp' => config('app.support.whatsapp'),
                'currentDate' => Carbon::now('America/Bogota')->format('d/m/Y H:i'),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
