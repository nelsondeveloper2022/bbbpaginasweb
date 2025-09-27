<?php

namespace App\Mail;

use App\Models\User;
use App\Models\BbbEmpresa;
use App\Models\BbbLanding;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class LandingPublishedCustomerNotification extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public BbbEmpresa $empresa;
    public BbbLanding $landing;
    public string $landingUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, BbbEmpresa $empresa, BbbLanding $landing, string $landingUrl)
    {
        $this->user = $user;
        $this->empresa = $empresa;
        $this->landing = $landing;
        $this->landingUrl = $landingUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: '¡Tu Landing Page está lista! - ' . $this->empresa->nombre,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.landing-published-customer',
            with: [
                'user' => $this->user,
                'empresa' => $this->empresa,
                'landing' => $this->landing,
                'landingUrl' => $this->landingUrl,
            ],
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
